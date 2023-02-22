async function tinyRobotTransform(audioBuffer) {

  let channels = [];
  for(let i = 0; i < audioBuffer.numberOfChannels; i++) { channels[i] = new Float32Array(audioBuffer.getChannelData(i)); }

  // Run worker
  let outputChannels = await doWorkerTask(function() {
    self.onmessage = function(e) {

      let inputChannels = e.data.channels;
      let sampleRate = e.data.sampleRate;
      let chunkSeconds = 0.05;
      let chunkSize = chunkSeconds*sampleRate;

      let outputChannels = [];
      for(let i = 0; i < inputChannels.length; i++) {
        let input = inputChannels[i];

        // cut input at nodal points
        let chunks = [];
        let currentChunk = [];
        for(let j = 0; j < input.length; j++) {
          if(currentChunk.length >= chunkSize) {
            chunks.push(currentChunk);
            currentChunk = [];
          }
          currentChunk.push(input[j]);
        }

        // play with chunks
        for(let j = 0; j < chunks.length; j++) {
          let dup = [...chunks[j]];
          chunks[j] = [...dup.reverse(), ...chunks[j], ...dup, ...dup.reverse()];
        }

        // join chunks
        let output = new Float32Array(chunks.reduce((a,v)=>{ return a + v.length; }, 0));
        let m = 0;
        for(let j = 0; j < chunks.length; j++) {
          for(let k = 0; k < chunks[j].length; k++) {
            output[m] = chunks[j][k];
            m++;
          }
        }

        // resample
        let resampledOutput = [];
        let desiredSamplesPerPoint = input.length / output.length;
        let numSamplesSoFar = 0;
        for(let j = 0; j < output.length; j++) {

          // If less than required sample ratio, grab another sample
          let numPointsSoFar = j+1;
          if(numSamplesSoFar/numPointsSoFar < desiredSamplesPerPoint) {
            resampledOutput.push(output[j]);
            numSamplesSoFar++;
          }
          // resampledOutput.push(output[j]);

        }

        outputChannels.push(Float32Array.from(resampledOutput));

      }

      self.postMessage(outputChannels, [...outputChannels.map(c => c.buffer), ...inputChannels.map(c => c.buffer)]);
      self.close();

    }
  }, {channels, sampleRate:audioBuffer.sampleRate}, channels.map(c => c.buffer))

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, outputChannels[0].length, audioBuffer.sampleRate);

  audioBuffer = ctx.createBuffer(outputChannels.length, outputChannels[0].length, audioBuffer.sampleRate);
  for(let i = 0; i < outputChannels.length; i++) { audioBuffer.copyToChannel(outputChannels[i], i); }

  return audioBuffer;

}
