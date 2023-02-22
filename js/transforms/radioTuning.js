async function radioTuningTransform(audioBuffer) {

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, audioBuffer.length, audioBuffer.sampleRate);

  let source = ctx.createBufferSource();
  source.buffer = audioBuffer;

  let compressor1 = ctx.createDynamicsCompressor();
  let compressor2 = ctx.createDynamicsCompressor();
  let inputGain = ctx.createGain();
  inputGain.gain.value = 0.8;

  let tuna = new Tuna(ctx);
  var effect = new tuna.MoogFilter({
    cutoff: 0.065,    //0 to 1
    resonance: 3.6,   //0 to 4
    bufferSize: 4096  //256 to 16384
});

  source.connect(inputGain);
  inputGain.connect(effect.input);
  effect.connect(compressor2);
  compressor2.connect(ctx.destination);

  source.start(0);
  return await ctx.startRendering();


}
