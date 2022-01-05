import React , {Component} from 'react';
import 'bootstrap/dist/css/bootstrap.css';
import {corsHeaders} from "./constants"
import {Form} from "./Form";
const axios = require('axios');

class App extends Component{

    state = {
        inpVal: "",
        resultInp: "",
    }

    render() {
        return (
            <div className="App bg-light">
                <div className="container py-5">
                    <Form/>
                </div>
            </div>
        )
    }
}

export default App;
