import React, { Component } from 'react'

export default class RepLogApp extends Component {
    render() {
        let heart = '';

        if (this.props.withHeart) {
            heart = <span>❤</span>;
        }

        return <h2>Lift Stuff! <span>{heart}</span></h2>;
    }
}