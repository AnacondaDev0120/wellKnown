async function pitchTransform(audioBuffer, pitchMod /*nagive=lower, positive=higher*/) {

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, audioBuffer.length, audioBuffer.sampleRate);

  let source = ctx.createBufferSource();
  source.buffer = audioBuffer;

  let pitchChangeEffect = new Jungle( ctx );

  let compressor = ctx.createDynamicsCompressor();
  //let filter = ctx.createBiquadFilter();
  //filter.type = "lowpass";
  //filter.frequency.value = 10000;

  source.connect(pitchChangeEffect.input)
  pitchChangeEffect.output.connect(compressor)
  pitchChangeEffect.setPitchOffset(pitchMod);

  compressor.connect(ctx.destination);
  //filter.connect(ctx.destination);

  source.start(0);
  return await ctx.startRendering();


}
