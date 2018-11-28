var ImageEditor = require('tui-image-editor');
// import { ImageEditor } from 'tui-image-editor';
let instance = false;
export function init(options) {
    // console.log(options);
    instance = new ImageEditor(options.el, {
        cssMaxWidth: 700,
        cssMaxHeight: 500,
        selectionStyle: {
            cornerSize: 20,
            rotatingPointOffset: 70,
        },
    });
    // Load sample image
    instance.loadImageFromURL(options.imgurl, 'SampleImage').then(sizeValue => {
        console.log(sizeValue);
        instance.clearUndoStack();
    });
    if (instance) return instance;
    else return false; 
}
export function destroy() {
    // console.log(instance);
    if(instance) instance.destroy();
}