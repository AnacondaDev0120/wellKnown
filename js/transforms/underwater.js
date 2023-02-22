async function underwaterTransform(audioBuffer) {

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, audioBuffer.length, audioBuffer.sampleRate);

  let source = ctx.createBufferSource();
  source.buffer = audioBuffer;

  let compressor1 = ctx.createDynamicsCompressor();
  let compressor2 = ctx.createDynamicsCompressor();
  let inputGain = ctx.createGain();
  inputGain.gain.value = 0.5;
  let filter = ctx.createBiquadFilter();
  filter.type = "lowpass";
  filter.frequency.value = 500;

  let underwater = ctx.createBufferSource();
  underwater.buffer = await ctx.decodeAudioData(await (await fetch("../audio/backgrounds/underwater1.mp3")).arrayBuffer());
  underwater.loop = true;
  let underwaterGain = ctx.createGain();
  underwaterGain.gain.value = 0.3;

  let tuna = new Tuna(ctx);
  var effect = new tuna.WahWah({
      automode: true,                //true/false
      baseFrequency: 0.02,            //0 to 1
      excursionOctaves: 1,           //1 to 6
      sweep: 0.2,                    //0 to 1
      resonance: 10,                 //1 to 100
      sensitivity: 0.5,              //-1 to 1
      bypass: 0
  });

  source.connect(inputGain);
  inputGain.connect(effect.input);
  effect.connect(filter);
  filter.connect(compressor2);
  compressor2.connect(ctx.destination);

  underwater.connect(underwaterGain);
  underwaterGain.connect(compressor2);

  source.start(0);
  underwater.start(0);
  return await ctx.startRendering();


}
