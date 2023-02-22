async function deepSynthTransform(audioBuffer) {

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, audioBuffer.length, audioBuffer.sampleRate);

  let carrier = await ctx.decodeAudioData(await (await fetch("/audio/junky-vocoder-modulator.ogg")).arrayBuffer());

  let compressor = ctx.createDynamicsCompressor();

  let v = vocoder(ctx, carrier, audioBuffer, {
    noise:1.64,
    synthDetune:600,
    sample:1,
    synth:2,
    modulatorGain:0.4,
  });

  v.output.connect(compressor);
  compressor.connect(ctx.destination);

  return await ctx.startRendering();

}
