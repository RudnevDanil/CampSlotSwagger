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
                        avatar: "123123123123123123123123123123123123123123123123123123123",
                        email: "123",
                        login: "1ww23w456",
                        pass: "123",
                        transportRating: "50",
                        transportName: "123",
                    }},
                {name: "auth", data: {
                        login: "12345",
                        pass: "123",
                    }},
                {name: "markPost", data: {
                        login: "123456",
                        pass: "123",
                        postId: "15",
                        doMark: "true",
                    }},
                {name: "removePost", data: {
                        login: "12345",
                        pass: "123",
                        postId: "7",
                    }},
                {name: "commentCreate", data: {
                        login: "12345",
                        pass: "123",
                        postId: "16",
                        imgs: JSON.stringify(["123123", "321321"]),
                        posText: "some positive text",
                        negText: "some negative text",
                        neuText: "some neutral text",
                        stars: "5",
                        isPaid: "true",//
                        paymentText: "some money" //
                    }},
                {name: "postCreate", data: {
                        login: "12345",
                        pass: "123",
                        title: "some title",
                        text: "some text",
                        imgs: JSON.stringify(["123123", "321321"]),
                        transportRating: "40",
                        isPaid: "true",
                        paymentText: "some payment text",
                        lat: "50.064192",
                        lon: "44.920110",
                        infrastructureArr: JSON.stringify(["water", "shower", "toilet"]),
                    }},
                {name: "getComments", data: {
                        postId: "16",
                        limit: "2",
                        offset: "0",
                    }},
                {name: "getPosts", data: {
                        // 47.234176, 39.701906 Ростов
                        // 51.668138, 39.197598 Воронеж 500-600 км до Ростова
                        // 56.852287, 35.888789 Тверь 1000-1200 км до Ростова
                        login: "12345",
                        pass: "123",
                        minTransportRating: "10",
                        minStarRating: "0.0",
                        lat: "47.234176",
                        lon: "39.701906",
                        dist: "1000.0",
                        infrastructureArr: JSON.stringify(["water"/*, "shower"*/]),
                        limit: "3",
                        offset: "0",
                    }},
                {name: "getPost", data: {
                        postId: "16",
                    }},
                {name: "getPostImgs", data: {
                        postId: "16",
                    }},
                {name: "getCommentImgs", data: {
                        postId: "16",
                        commentsIds: JSON.stringify(["5", "6"])
                    }},
                {name: "getUserPage", data: {
                        userId: "3",
                    }},
                {name: "getMarkedPosts", data: {
                        userId: "3",
                        limit: "2",
                        offset: "0",
                    }},
                {name: "getApiUrl", data: {}},
            ]

            let request = requests.filter(r => r.name === "getApiUrl")[0]
            let response = await axios({
                method: 'post',
                url: 'http://h96046yr.beget.tech/campSlot/' + request.name + '.php/',
                headers: {...corsHeaders, "Content-type": "application/json; charset=UTF-8"},
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
