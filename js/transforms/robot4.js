async function robot4Transform(audioBuffer) {

  let channels = [];
  for(let i = 0; i < audioBuffer.numberOfChannels; i++) { channels[i] = new Float32Array(audioBuffer.getChannelData(i)); }

  // Run worker
  let outputChannels = await doWorkerTask(function() {
    self.onmessage = function(e) {

      let inputChannels = e.data.channels;
      let outputChannels = [];
      for(let i = 0; i < inputChannels.length; i++) {
        outputChannels[i] = new Float32Array( inputChannels[i].length );
        let beepboopMod = 0, beepboop = 0, delay0 = 0, delay1 = 0, delay2 = 0, delay3 = 0;
        for(let j = 0; j < inputChannels[i].length; j++) {
          if(j%1700 === 0) { beepboopMod = Math.random(); }
          beepboop = Math.sin(j*beepboopMod) * 0.05;
          //delay0 = Math.sin(j/80) * 100;
          delay1 = Math.sin(j/400) * 100;
          delay2 = Math.sin(j/200) * 100;
          delay3 = Math.sin(j/100) * 100;
          outputChannels[i][j] = inputChannels[i][Math.round(j-delay0-delay1-delay2)]*0.9 + beepboop;
        }
      }

      self.postMessage(outputChannels, [...outputChannels.map(c => c.buffer), ...inputChannels.map(c => c.buffer)]);
      self.close();

    }
  }, {channels}, channels.map(c => c.buffer))

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, outputChannels[0].length, audioBuffer.sampleRate);

  let outputAudioBuffer = ctx.createBuffer(outputChannels.length, outputChannels[0].length, audioBuffer.sampleRate);
  for(let i = 0; i < outputChannels.length; i++) { outputAudioBuffer.copyToChannel(outputChannels[i], i); }

  return outputAudioBuffer;

}
