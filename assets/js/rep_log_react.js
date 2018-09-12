import React from 'react'
import { render } from 'react-dom'
import Geography from './RepLog/Geography'
import MapComponent from './RepLog/GoogleMaps'

const shouldShowHeart = true;

// render(
//     <Geography />,
//     document.getElementById('lift-stuff-app')
// );

render(<MapComponent isMarkerShown />, document.getElementById("lift-stuff-app"));