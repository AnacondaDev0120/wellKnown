async function schoolPATransform(audioBuffer) {

  let channels = [];
  for(let i = 0; i < audioBuffer.numberOfChannels; i++) { channels[i] = new Float32Array(audioBuffer.getChannelData(i)); }

  // Run worker
  let outputChannels = await doWorkerTask(function() {
    self.onmessage = function(e) {

      let inputChannels = e.data.channels;
      let sampleRate = e.data.sampleRate;
      let secondsPerChunk = 2;
      let samplesPerChunk = secondsPerChunk*sampleRate;

      let outputChannels = [];
      for(let i = 0; i < inputChannels.length; i++) {

        let input = inputChannels[i];
        let output = new Float32Array(input.length);
        let m = 0;
        let doFlip = false;
        for(let j = 0; j < input.length; j++) {
          if(j%100 === 0 && Math.random() < 0.2) { doFlip = !doFlip; }
          if(doFlip) {
            output[j] = Math.abs(input[j]);
          } else {
            output[j] = input[j];
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



  let source = ctx.createBufferSource();
  source.buffer = audioBuffer;

  let filter = ctx.createBiquadFilter();
  filter.type = "lowpass";
  filter.frequency.value = 2000;

  //source.connect(ctx.destination)
  source.connect(filter)
  filter.connect(ctx.destination);

  source.start(0);
  return await ctx.startRendering();

}
