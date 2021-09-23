import React , {Component} from 'react';
import 'bootstrap/dist/css/bootstrap.css';

import {corsHeaders} from "./constants"
const axios = require('axios');

class App extends Component{

    state = {
        inpVal: "",
        resultInp: "",
    }

    async send(){
        try {
            let requests = [
                {name: "userCreate", data: {
                        img: "123123123123123123123123123123123123123123123123123123123",
                        email: "123",
                        login: "123456",
                        pass: "123",
                        transportName: "123",
                        transportFlag: "123",
                    }},
                {name: "auth", data: {
                        login: "12345",
                        pass: "123",
                    }},
                {name: "markPost", data: {
                        login: "12345",
                        pass: "123",
                        postId: "5",
                        doMark: "false",
                    }},
                {name: "removePost", data: {
                        login: "12345",
                        pass: "123",
                        postId: "7",
                    }},
                {name: "commentCreate", data: {
                        login: "12345",
                        pass: "123",
                        postId: "1",
                        imgs: JSON.stringify(["123123", "321321"]),
                        posText: "some positive text",
                        negText: "some negative text",
                        neuText: "some neutral text",
                        stars: "3.4"
                    }},
                {name: "postCreate", data: {
                        login: "12345",
                        pass: "123",
                        title: "some title",
                        text: "some text",
                        imgs: JSON.stringify(["123123", "321321"]),
                        transportFlag: "123321",
                        infrastructureFlag: "456654",
                        isPaid: "true",
                        paymentText: "some payment text",
                        lat: "50.064192",
                        lon: "44.920110",
                    }},
                {name: "getComments", data: {
                        postId: "1",
                        limit: "3",
                        offset: "0",
                    }},
                {name: "getPosts", data: {
                        login: "12345",
                        pass: "123",
                        transportFlag: "123321",
                        minStarRating: "3.4",
                        lat: "50.064192",
                        lon: "44.920110",
                        dist: "10000",
                    }},
                {name: "getPost", data: {
                        postId: "1",
                    }},
                {name: "getPostImgs", data: {
                        postId: "1",
                    }},
                {name: "getUserPage", data: {
                        login: "12345",
                        pass: "123",
                    }},
                {name: "getMarkedPosts", data: {
                        userId: "1",
                        limit: "10",
                        offset: "0",
                    }},
                {name: "changeIsPaid", data: {
                        login: "123456",
                        pass: "123",
                        postId: "3",
                        isPaid: "true",
                        paymentText: "some new payment text",
                    }},
            ]

            let request = requests.filter(r => r.name === "changeIsPaid")[0]
            let response = await axios({
                method: 'post',
                url: 'http://h96046yr.beget.tech/campSlot/' + request.name + '.php/',
                headers: {"Content-type": "application/json; charset=UTF-8"},
                data: request.data
            })

            return (response.status === 200 ? JSON.stringify(response.data) : "response status = " + response.status)
        } catch (error) {
            return null
        }
    }

    render() {
        return (
            <div className="App bg-light">
                <div className="container">
                    <div className="row px-5 py-5">
                        <div className="col-12 mt-5 px-5 py-5">
                            <div className="input-group">
                                <input className="form-control" type="text" placeholder="Data package"
                                    defaultValue={this.state.inpVal}
                                    onBlur={e => {this.setState({inpVal:e.target.value})}}
                                />

                                <button className="btn btn-outline-secondary" type="button"
                                    onClick={() => {
                                        this.setState({resultInp: ""});
                                        (async() => {
                                            let result = await this.send()
                                            this.setState({resultInp: result ? result : "error"});
                                        })()
                                    }}
                                >
                                    <i className="fas fa-arrow-right"/>
                                </button>
                            </div>
                        </div>

                        <div className="col-12 px-5">
                            <div className="input-group">
                                <textarea className="form-control" id="exampleFormControlTextarea1" rows="10"
                                       defaultValue={this.state.resultInp}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default App;
