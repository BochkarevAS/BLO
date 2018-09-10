import React from 'react'
import ReactDom from 'react-dom'

// const el = React.createElement('h2', null, 'History', React.createElement('span', null, '❤️'));
const el = <h2>Lift Stuff! <span>❤️</span></h2>;


ReactDom.render(el, document.getElementById('lift-stuff-app'));

console.log(el);