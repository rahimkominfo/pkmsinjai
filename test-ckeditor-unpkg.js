const { JSDOM } = require('jsdom');
const fs = require('fs');
const dom = new JSDOM(`<!DOCTYPE html><html><body><textarea id="konten"></textarea></body></html>`, {
  url: "http://localhost/",
  runScripts: "dangerously"
});

const window = dom.window;
const document = window.document;

// Use the local script file
const scriptText = fs.readFileSync('ckeditor5-unpkg.umd.js', 'utf-8');

const scriptEl = document.createElement('script');
scriptEl.textContent = scriptText;
document.body.appendChild(scriptEl);

setTimeout(() => {
  try {
    const CKEDITOR = window.CKEDITOR;
    const {
        ClassicEditor, Essentials, Paragraph, Bold, Italic, Image, ImageInsert, ImageToolbar, ImageCaption, ImageStyle, Alignment, SourceEditing, Heading, List, Link, BlockQuote
    } = CKEDITOR;

    ClassicEditor
        .create(document.querySelector('#konten'), {
            licenseKey: 'GPL',
            plugins: [
                Essentials, Paragraph, Bold, Italic,
                Image, ImageInsert, ImageToolbar, ImageCaption, ImageStyle,
                Alignment, SourceEditing, Heading, List, Link, BlockQuote
            ],
            toolbar: [
                'undo', 'redo', '|', 'bold', 'italic'
            ]
        })
        .then(editor => {
            console.log("Editor initialized successfully");
        })
        .catch(error => {
            console.error("CKEditor Init Error:", error.message || error);
        });
  } catch (err) {
    console.error("Evaluation error:", err);
  }
}, 2000);
