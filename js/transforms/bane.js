async function baneTransform(audioBuffer) {

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, audioBuffer.length, audioBuffer.sampleRate);
  let source = ctx.createBufferSource();
  source.buffer = audioBuffer;

  // Wave shaper
  let waveShaper = ctx.createWaveShaper();
  waveShaper.curve = makeDistortionCurve(7);
  function makeDistortionCurve(amount) {
    var k = typeof amount === 'number' ? amount : 50;
    var n_samples = 44100;
    var curve = new Float32Array(n_samples);
    var deg = Math.PI / 180;
    var x;
    for (let i = 0; i < n_samples; ++i ) {
      x = i * 2 / n_samples - 1;
      curve[i] = ( 3 + k ) * x * 20 * deg / (Math.PI + k * Math.abs(x));
    }
    return curve;
  }

  // Pitch
  let deeper = new Jungle( ctx );
  deeper.setPitchOffset(-0.25);

  // Telephone
  let lpf1 = ctx.createBiquadFilter();
  lpf1.type = "lowpass";
  lpf1.frequency.value = 5000.0;
  let lpf2 = ctx.createBiquadFilter();
  lpf2.type = "lowpass";
  lpf2.frequency.value = 5000.0;
  let hpf1 = ctx.createBiquadFilter();
  hpf1.type = "highpass";
  hpf1.frequency.value = 100.0;
  let hpf2 = ctx.createBiquadFilter();
  hpf2.type = "highpass";
  hpf2.frequency.value = 100.0;
  let compressor = ctx.createDynamicsCompressor();
  lpf1.connect( lpf2 );
  lpf2.connect( hpf1 );
  hpf1.connect( hpf2 );
  hpf2.connect( waveShaper );


  source.connect(deeper.input);
  deeper.output.connect(lpf1);

  waveShaper.connect( compressor );
  compressor.connect( ctx.destination );

  source.start(0);
  return await ctx.startRendering();

}
