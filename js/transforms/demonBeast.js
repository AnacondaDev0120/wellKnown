self.AudioContext = (self.AudioContext || self.webkitAudioContext);
async function demonBeastTransform(audioBuffer, distortionAmount=100) {

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, audioBuffer.length, audioBuffer.sampleRate);

  // Source
  let source = ctx.createBufferSource();
  source.buffer = audioBuffer;

  // Reverb
  let convolver = ctx.createConvolver();
  convolver.buffer = await ctx.decodeAudioData(await (await fetch("/audio/impulse-responses/voxengo/Large Wide Echo Hall.wav")).arrayBuffer());
  // convolver.buffer = await ctx.decodeAudioData(await (await fetch("../audio/impulse-responses/zapsplat_musical_recorder_slide_in_pouch_case.mp3")).arrayBuffer());

  // Fire
  let fire = ctx.createBufferSource();
  fire.buffer = await ctx.decodeAudioData(await (await fetch("/audio/backgrounds/brush_fire-Stephan_Schutze-55390065.mp3")).arrayBuffer());
  fire.loop = true;

  // Compressor
  let compressor = ctx.createDynamicsCompressor();
  compressor.threshold.value = -50;
  compressor.ratio.value = 16;

  // Wobble
  let oscillator = ctx.createOscillator();
  oscillator.frequency.value = 50;
  oscillator.type = 'sawtooth';
  // ---
  let oscillatorGain = ctx.createGain();
  oscillatorGain.gain.value = 0.004;
  // ---
  let delay = ctx.createDelay();
  delay.delayTime.value = 0.01;
  // ---
  let fireGain = ctx.createGain();
  fireGain.gain.value = 0.2;
  // ---
  let convolverGain = ctx.createGain();
  convolverGain.gain.value = 2;

  // Filter
  let filter = ctx.createBiquadFilter();
  filter.type = "highshelf";
  filter.frequency.value = 1000;
  filter.gain.value = 10;

  // Create graph
  oscillator.connect(oscillatorGain);
  oscillatorGain.connect(delay.delayTime);
  // ---
  source.connect(delay)
  delay.connect(convolver);
  //waveShaper.connect(convolver);

  fire.connect(fireGain);
  convolver.connect(convolverGain);

  convolverGain.connect(filter);
  filter.connect(compressor);

  fireGain.connect(ctx.destination);

  compressor.connect(ctx.destination);

  let filter2 = ctx.createBiquadFilter();
  filter2.type = "lowpass";
  filter2.frequency.value = 2000;
  let noConvGain = ctx.createGain();
  noConvGain.gain.value = 0.9;
  delay.connect(filter2);
  filter2.connect(filter);
  filter.connect(noConvGain);
  noConvGain.connect(compressor);

  // Render
  oscillator.start(0);
  source.start(0);
  fire.start(0);
  let outputAudioBuffer = await ctx.startRendering();
  return outputAudioBuffer;

}
