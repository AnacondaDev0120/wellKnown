self.AudioContext = (self.AudioContext || self.webkitAudioContext);
async function alienRobot1Transform(audioBuffer) {

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, audioBuffer.length, audioBuffer.sampleRate);

  let source = ctx.createBufferSource();
  source.buffer = audioBuffer;

  let oscillator = ctx.createOscillator();
  oscillator.frequency.value = 40;
  oscillator.type = 'sine';

  let oscillatorGain = ctx.createGain();
  oscillatorGain.gain.value = 0.015;

  let delay = ctx.createDelay();
  delay.delayTime.value = 0.05;

  // source --> delay --> ctx.destination
  // oscillator --> oscillatorGain --> delay.delayTime --> ctx.destination

  source.connect(delay);
  delay.connect(ctx.destination);

  oscillator.connect(oscillatorGain);
  oscillatorGain.connect(delay.delayTime);

  oscillator.start();
  source.start();

  let outputAudioBuffer = await ctx.startRendering();
  return outputAudioBuffer;

}
