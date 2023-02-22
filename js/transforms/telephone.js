async function telephoneTransform(audioBuffer) {

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, audioBuffer.length, audioBuffer.sampleRate);
  let source = ctx.createBufferSource();
  source.buffer = audioBuffer;

  let lpf1 = ctx.createBiquadFilter();
  lpf1.type = "lowpass";
  lpf1.frequency.value = 2000.0;
  let lpf2 = ctx.createBiquadFilter();
  lpf2.type = "lowpass";
  lpf2.frequency.value = 2000.0;
  let hpf1 = ctx.createBiquadFilter();
  hpf1.type = "highpass";
  hpf1.frequency.value = 500.0;
  let hpf2 = ctx.createBiquadFilter();
  hpf2.type = "highpass";
  hpf2.frequency.value = 500.0;
  let compressor = ctx.createDynamicsCompressor();
  lpf1.connect( lpf2 );
  lpf2.connect( hpf1 );
  hpf1.connect( hpf2 );
  hpf2.connect( compressor );
  compressor.connect( ctx.destination );

  source.connect(lpf1);

  source.start(0);
  return await ctx.startRendering();

}
