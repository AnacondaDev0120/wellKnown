self.AudioContext = (self.AudioContext || self.webkitAudioContext);
async function caveTransform(audioBuffer) {

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, audioBuffer.length, audioBuffer.sampleRate);

  // Source
  let source = ctx.createBufferSource();
  source.buffer = audioBuffer;

  // Reverb
  let convolver = ctx.createConvolver();
  convolver.buffer = await ctx.decodeAudioData(await (await fetch("/audio/impulse-responses/voxengo/Large Long Echo Hall.wav")).arrayBuffer());

  // Create graph
  source.connect(convolver);
  convolver.connect(ctx.destination);

  // Render
  source.start();
  let outputAudioBuffer = await ctx.startRendering();
  return outputAudioBuffer;

}
