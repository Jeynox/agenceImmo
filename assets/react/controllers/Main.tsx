import React from 'react';
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Login from "./pages/Login";
import Home from './pages/Home'
import Sign from './pages/Sign';

export default function Main() {

    return (
        <Router>
            <Routes>
                <Route  path="/" element={<Home />} />
                    <Route path='/login' element={<Login />}/>
                    <Route path='/sign' element={<Sign />}/>
            </Routes>
        </Router>
        
    );
}
