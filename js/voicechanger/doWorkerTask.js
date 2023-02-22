async function doWorkerTask(workerFunction, input, buffers) {
  // Create worker
  let fnString = '(' + workerFunction.toString().replace('"use strict";', '') + ')();';
  let workerBlob = new Blob([fnString]);
  let workerBlobURL = window.URL.createObjectURL(workerBlob, { type: 'application/javascript; charset=utf-8' });
  let worker = new Worker(workerBlobURL);

  // Run worker
  return await new Promise(function(resolve, reject) {
    worker.onmessage = function(e) { resolve(e.data); };
    worker.postMessage(input, buffers);
  });
}
