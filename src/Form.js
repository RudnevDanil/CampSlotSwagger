import React, {useState} from "react";
import {defaultStartSettings} from "./defaultStartSettings.js"
import {FormControl, InputLabel, MenuItem, Select, TextField} from "@mui/material";
import {corsHeaders} from "./constants";

const axios = require('axios');

export function Form() {
    const [card, setCard] = useState(defaultStartSettings)
    const [curr, setCurr] = useState(null)
    const [btnColor, setBtnColor] = useState('dark')
    const [responseResult, setResponseResult] = useState(null)

    let send = async () => {
        if(btnColor !== 'dark')
            return;

        setResponseResult(null)
        setBtnColor('warning')

        try {
            let response = await axios({
                method: 'post',
                url: 'http://h96046yr.beget.tech/campSpot/' + curr.name + '.php/',
                headers: {...corsHeaders, "Content-type": "application/json; charset=UTF-8"},
                data: curr.data
            })

            if(response.status !== 200){
                setBtnColor('danger')
                setResponseResult("--- Error --- statusCode: " + response.status)
            }

            setBtnColor('success')
            setResponseResult(JSON.stringify(response.data))

        } catch (error) {
            setBtnColor('danger')
            setResponseResult("--- Error --- statusCode: " + (error.response ? error.response.status : 500))
        }
        setTimeout(() => {setBtnColor('dark')}, 500)
    }

    if(!card.length)
        return <></>

    return (
        <>
            <div className="row m-0 mw-100">
                <div className="col-6 ps-0">
                    <FormControl fullWidth>
                        <InputLabel>Method</InputLabel>
                        <Select
                            value={curr && curr.name}
                            label="Method"
                            onChange={e => {setCurr(card.filter(el => el.name === e.target.value)[0])}}
                        >
                            {card.map((el, i) => (<MenuItem value={el.name} key={"MenuItem_" + i}>{el.name}</MenuItem>))}
                        </Select>
                    </FormControl>
                </div>

                <div className="col-6 pe-0 d-flex align-items-center">
                    {
                        curr ?
                            <button type="button"
                                    className={"btn btn-outline-" + btnColor}
                                    onClick={send}
                            >
                                Send
                                &nbsp;&nbsp;
                                <i className="far fa-paper-plane"/>
                            </button>
                            : null
                    }
                </div>

                {
                    responseResult ?
                        <div className="col-12 pt-4 px-0">
                            <TextField
                                className="w-100"
                                label="Result"
                                value={responseResult}
                                variant="outlined"
                                error={("" + responseResult).indexOf("--- Error ---") !== -1}
                            />
                        </div>
                        : null
                }

            </div>

            {
                curr ?
                    <div className="border rounded-3 mt-4">
                        <div className="row m-0 mw-100 px-2 pb-2">
                        {
                            Object.keys(curr.data).map((k, i) => (
                                <div className="col-6 p-2 pt-4">
                                    <TextField
                                        className="w-100"
                                        label={k}
                                        value={curr.data[k]}
                                        variant="outlined"
                                        key={"TextField_" + i}
                                        onChange={e => {setCurr({...curr, data: {...curr.data, [k]: e.target.value}})}}
                                    />
                                </div>
                            ))
                        }
                        </div>
                    </div>
                    : null
            }
        </>
    )
}