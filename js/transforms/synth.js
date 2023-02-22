async function synthTransform(audioBuffer) {

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, audioBuffer.length, audioBuffer.sampleRate);

  let carrier = await ctx.decodeAudioData(await (await fetch("/audio/junky-vocoder-modulator.ogg")).arrayBuffer());

  let compressor = ctx.createDynamicsCompressor();

  let v = vocoder(ctx, carrier, audioBuffer);

  v.output.connect(compressor);
  compressor.connect(ctx.destination);

  return await ctx.startRendering();

}
