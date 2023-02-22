async function giantRobotTransform(audioBuffer) {

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, audioBuffer.length, audioBuffer.sampleRate);

  let source = ctx.createBufferSource();
  source.buffer = audioBuffer;

  let dee = new Jungle( ctx );
  dee.setPitchOffset(-0.1);

  let deep = new Jungle( ctx );
  deep.setPitchOffset(-0.2);

  let deeper = new Jungle( ctx );
  deeper.setPitchOffset(-0.4);

  let deeperer = new Jungle( ctx );
  deeperer.setPitchOffset(-0.8);

  let compressor = ctx.createDynamicsCompressor();

  source.connect(dee.input);
  source.connect(deep.input);
  source.connect(deeper.input);
  source.connect(deeperer.input);

  dee.output.connect(compressor);
  deep.output.connect(compressor);
  deeper.output.connect(compressor);
  deeperer.output.connect(compressor);

  compressor.connect(ctx.destination);

  source.start(0);
  return await ctx.startRendering();


}
