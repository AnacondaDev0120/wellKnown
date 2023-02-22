async function chunkedReversedTransform(audioBuffer) {

  let channels = [];
  for(let i = 0; i < audioBuffer.numberOfChannels; i++) { channels[i] = new Float32Array(audioBuffer.getChannelData(i)); }

  // Run worker
  let outputChannels = await doWorkerTask(function() {
    self.onmessage = function(e) {

      let inputChannels = e.data.channels;
      let sampleRate = e.data.sampleRate;
      let chunkSeconds = 0.7;
      let chunkSize = chunkSeconds*sampleRate;

      let outputChannels = [];
      for(let i = 0; i < inputChannels.length; i++) {
        let input = inputChannels[i];
        let output = new Float32Array(input.length);

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
          chunks[j].reverse();
        }

        // join chunks
        let m = 0;
        for(let j = 0; j < chunks.length; j++) {
          for(let k = 0; k < chunks[j].length; k++) {
            output[m] = chunks[j][k];
            m++;
          }
        }

        outputChannels.push(output);

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
