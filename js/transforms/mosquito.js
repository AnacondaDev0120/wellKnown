async function mosquitoTransform(audioBuffer) {

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, audioBuffer.length, audioBuffer.sampleRate);

  let source = ctx.createBufferSource();
  source.buffer = audioBuffer;

  let pitchChangeEffect = new Jungle( ctx );

  let compressor = ctx.createDynamicsCompressor();

  source.connect(pitchChangeEffect.input)
  pitchChangeEffect.output.connect(compressor)
  pitchChangeEffect.setPitchOffset(5);

  compressor.connect(ctx.destination);
  //filter.connect(ctx.destination);

  source.start(0);
  return await ctx.startRendering();


}
