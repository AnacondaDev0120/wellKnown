self.AudioContext = (self.AudioContext || self.webkitAudioContext);
async function autowahTransform(audioBuffer) {

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, audioBuffer.length, audioBuffer.sampleRate);

  let inputNode = ctx.createBufferSource();
  inputNode.buffer = audioBuffer;

  let waveshaper = ctx.createWaveShaper();
  let awFollower = ctx.createBiquadFilter();
  awFollower.type = "lowpass";
  awFollower.frequency.value = 10.0;

  let curve = new Float32Array(65536);
  for (let i=-32768; i<32768; i++) {
    curve[i+32768] = ((i>0)?i:-i)/32768;
  }
  waveshaper.curve = curve;
  waveshaper.connect(awFollower);

  let wetGain = ctx.createGain();
  wetGain.gain.value = 1;

  let compressor = ctx.createDynamicsCompressor();
  compressor.threshold.value = -20;
  compressor.ratio.value = 16;

  let awDepth = ctx.createGain();
  awDepth.gain.value = 11585;
  awFollower.connect(awDepth);

  let awFilter = ctx.createBiquadFilter();
  awFilter.type = "lowpass";
  awFilter.Q.value = 15;
  awFilter.frequency.value = 50;
  awDepth.connect(awFilter.frequency);
  awFilter.connect(wetGain);

  inputNode.connect(waveshaper);
  inputNode.connect(awFilter);

  waveshaper.connect(compressor);
  wetGain.connect(compressor);
  compressor.connect(ctx.destination);

  inputNode.start(0);
  let outputAudioBuffer = await ctx.startRendering();
  return outputAudioBuffer;

}
