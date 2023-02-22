self.AudioContext = (self.AudioContext || self.webkitAudioContext);
async function distopianPASpeakerTransform(audioBuffer, distortionAmount=100) {

  let ctx = new OfflineAudioContext(audioBuffer.numberOfChannels, audioBuffer.length, audioBuffer.sampleRate);

  // Source
  let source = ctx.createBufferSource();
  source.buffer = audioBuffer;

  // Wave shaper
  let waveShaper = ctx.createWaveShaper();
  waveShaper.curve = makeDistortionCurve(distortionAmount);
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

  // Reverb
  let convolver = ctx.createConvolver();
  convolver.buffer = await ctx.decodeAudioData(await (await fetch("/audio/impulse-responses/voxengo/Parking Garage.wav")).arrayBuffer());
  // convolver.buffer = await ctx.decodeAudioData(await (await fetch("../audio/impulse-responses/church.wav")).arrayBuffer());

  // Filter
  let filter = ctx.createBiquadFilter();
  filter.type = "lowpass";
  filter.frequency.value = 1300;

  // Create graph
  // source.connect(convolver);
  source.connect(filter);
  filter.connect(convolver);
  convolver.connect(waveShaper);
  waveShaper.connect(ctx.destination);

  // Render
  source.start();
  let outputAudioBuffer = await ctx.startRendering();
  return outputAudioBuffer;

}
