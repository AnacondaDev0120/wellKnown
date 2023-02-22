self.AudioContext = (self.AudioContext || self.webkitAudioContext);
async function robot2Transform(audioBuffer) {

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, audioBuffer.length, audioBuffer.sampleRate);

  // Source
  let source = ctx.createBufferSource();
  source.buffer = audioBuffer;

  // Wobble
  let oscillator1 = ctx.createOscillator();
  oscillator1.frequency.value = 50;
  oscillator1.type = 'sawtooth';
  let oscillator2 = ctx.createOscillator();
  oscillator2.frequency.value = 1000;
  oscillator2.type = 'sawtooth';
  let oscillator3 = ctx.createOscillator();
  oscillator3.frequency.value = 50;
  oscillator3.type = 'sine';
  // ---
  let oscillatorGain = ctx.createGain();
  oscillatorGain.gain.value = 0.004;
  // ---
  let delay = ctx.createDelay();
  delay.delayTime.value = 0.01;

  // Create graph
  oscillator1.connect(oscillatorGain);
  oscillator2.connect(oscillatorGain);
  oscillator3.connect(oscillatorGain);
  oscillatorGain.connect(delay.delayTime);
  // ---
  source.connect(delay)
  delay.connect(ctx.destination);

  // Render
  oscillator1.start(0);
  oscillator2.start(0);
  oscillator3.start(0);
  source.start(0);
  // fire.start(0);
  let outputAudioBuffer = await ctx.startRendering();
  return outputAudioBuffer;

}
