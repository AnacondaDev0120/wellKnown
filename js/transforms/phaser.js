async function phaserTransform(audioBuffer) {

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, audioBuffer.length, audioBuffer.sampleRate);

  let source = ctx.createBufferSource();
  source.buffer = audioBuffer;

  let tuna = new Tuna(ctx);
  let effect = new tuna.Phaser({
      rate: 8,                     //0.01 to 8 is a decent range, but higher values are possible
      depth: 0.3,                    //0 to 1
      feedback: 0.9,                 //0 to 1+
      stereoPhase: 100,               //0 to 180
      baseModulationFrequency: 500,  //500 to 1500
      bypass: 0
  });
  source.connect(effect.input);
  effect.connect(ctx.destination);

  source.start(0);
  return await ctx.startRendering();


}
