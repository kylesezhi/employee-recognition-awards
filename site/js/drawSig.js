//Code adapted from Szymon Nowak's Signature Pad project: https://github.com/szimek/signature_pad

// Based on: http://stackoverflow.com/questions/5292372/how-to-pass-parameters-to-a-script-tag
function getParams() {
     var scripts = document.getElementsByTagName('script');
     var lastScript = scripts[scripts.length-1];
     var scriptName = lastScript;
     var id = scriptName.getAttribute('data-id');
     return id;
 }

var wrapper = document.getElementById("signature-pad"),
    clearButton = wrapper.querySelector("[data-action=clear]"),
    saveButton = wrapper.querySelector("[data-action=save]"),
    canvas = wrapper.querySelector("canvas"),
    signaturePad;

// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

signaturePad = new SignaturePad(canvas, {minWidth:0.75, maxWidth:1.5});

clearButton.addEventListener("click", function (event) {
    signaturePad.clear();
});

saveButton.addEventListener("click", function (event) {
    var id = getParams();
    if (id === null ) {
      id = '';
    } else {
      id = '?id=' + id;
    }
    if (signaturePad.isEmpty()) {
        alert("Please provide signature first.");
    } else {
			
		//Get raw data
		var imageData = signaturePad.toDataURL();
		
		//Submit via hidden form -- following code adapted from http://stackoverflow.com/questions/133925/javascript-post-request-like-a-form-submit
		var sigForm = document.createElement("form");
		sigForm.setAttribute("method", "post");
		sigForm.setAttribute("action", "uploadSig.php" + id);

		var hiddenField = document.createElement("input");
		hiddenField.setAttribute("type", "hidden");
		hiddenField.setAttribute("name", "signature");
		hiddenField.setAttribute("value", imageData);

		sigForm.appendChild(hiddenField);
			 
		document.body.appendChild(sigForm);
		sigForm.submit();
	}

});
