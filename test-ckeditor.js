const { JSDOM } = require('jsdom');
const dom = new JSDOM(`<!DOCTYPE html><html><body><textarea id="konten"></textarea></body></html>`, {
  url: "http://localhost/",
  runScripts: "dangerously"
});

const window = dom.window;
const document = window.document;

fetch('https://cdn.ckeditor.com/ckeditor5/48.2.0/ckeditor5.umd.js')
  .then(res => res.text())
  .then(scriptText => {
    const scriptEl = document.createElement('script');
    scriptEl.textContent = scriptText;
    document.body.appendChild(scriptEl);
    
    setTimeout(() => {
      try {
        const CKEDITOR = window.CKEDITOR;
        if (!CKEDITOR) {
            console.log("CKEDITOR is not defined");
            return;
        }
        const {
            ClassicEditor,
            Essentials,
            Paragraph,
            Bold,
            Italic,
            Image,
            ImageInsert,
            ImageToolbar,
            ImageCaption,
            ImageStyle,
            Alignment,
            SourceEditing,
            Heading,
            List,
            Link,
            BlockQuote
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
                    'undo', 'redo', '|',
                    'sourceEditing', '|',
                    'heading', '|',
                    'bold', 'italic', '|',
                    'alignment', '|',
                    'bulletedList', 'numberedList', '|',
                    'link', 'insertImage', 'blockQuote'
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
  });
