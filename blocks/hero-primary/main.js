const heroDrawingColor = getComputedStyle(document.documentElement).getPropertyValue('--color-theme-yellow');
const heroCanvas = document.getElementById( 'hero-primary__canvas' );
const heroClearButton = document.getElementById( 'canvas-clear-button' );
const heroCtx = ( heroCanvas ) ? heroCanvas.getContext( '2d' ) : '';
const canvasOffsetX = ( heroCanvas ) ? heroCanvas.offsetLeft : '';
const canvasOffsetY = ( heroCanvas ) ? heroCanvas.offsetTop : '';
const lineWidth = 5;

// Specify the width and height of the hero canvas:
if ( heroCanvas ) {
    heroCanvas.width = heroCtx.canvas.clientWidth;
    heroCanvas.height = heroCtx.canvas.clientHeight;
    let isPainting = false;
    let startX, startY;

    heroCtx.strokeStyle = heroDrawingColor;

    const heroDraw = ( e ) => {
        if( ! isPainting ) {
            return;
        }
        // Set line's width.
        heroCtx.lineWidth = lineWidth;
        // Gives the line a 'pen-like' effect.
        heroCtx.lineCap = 'round';
        // Create the line based ont he user's mouse:
        heroCtx.lineTo(e.clientX - offsetX, e.clientY - offsetY);
        // Draw the created line on the canvas AS THE USER DRAWS:
        heroCtx.stroke();
    }

    const clearDrawing = ( e ) => {
        heroCtx.clearRect(0, 0, heroCanvas.width, heroCanvas.height);
    }

    heroClearButton.addEventListener('click', clearDrawing);

    // Add event listener for user mouse down (this will draw on the canvas):
    heroCanvas.addEventListener( 'mousedown', ( e ) => {
        isPainting = true;

        // Get where the user STARTED drawing from:
        offsetX = e.target.getBoundingClientRect().left;
        offsetY = e.target.getBoundingClientRect().top;

        heroCtx.beginPath();
        heroCtx.moveTo(e.clientX - offsetX, e.clientY - offsetY);

    });

    // Add event listener for user mouse up (this means the user has stopped drawing):
    heroCanvas.addEventListener( 'mouseup', ( e ) => {
        isPainting = false;

        // Colors the line.
        heroCtx.stroke();

        // Closes the drawn path.
        heroCtx.beginPath();
    });

    // Add actual drawing listener:
    heroCanvas.addEventListener( 'mousemove', heroDraw);
    document.addEventListener('DOMContentLoaded', function() {
        // Your existing code here
    });
}
