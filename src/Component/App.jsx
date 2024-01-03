import React, { useEffect } from "react";

import { Layout } from 'antd';

import {
    getOptions,
    updateOptins,
    getPostTypes,
} from "../Utils/Data";

const { Sider } = Layout;

import * as Types from "../Utils/actionType";

import Settings from "./Settings";

import NeedSupport from "./NeedSupport";

import MainHeader from "./MainHeader";

import { useStateValue } from "../Utils/StateProvider";

function App() {

    const [ stateValue, dispatch ] = useStateValue();
    const getTheOptins = async () => {
        const response = await getOptions();
        const preparedData =  await JSON.parse( response.data );
        await dispatch({
            type: Types.UPDATE_OPTIONS,
            options: {
                ...preparedData,
                isLoading: false,
            }
        });
        console.log( 'getOptions' );
    }

    const getThePostTypes = async () => {
        const response = await getPostTypes();
        const preparedData =  await JSON.parse( response.data );

        await dispatch({
            type: Types.GENERAL_DATA,
            generalData: {
                ...stateValue.generalData,
                postTypes: preparedData,
                isLoading: false,
            }
        });
        console.log( 'getPostTypes' );
    }

    const handleUpdateOption = async () => {
       const response = await updateOptins( stateValue.options );
       if( 200 === parseInt( response.status ) ){
           await getTheOptins();
       }
       console.log( 'handleUpdateOption' );
    }


    const handleSave = () => {
        switch ( stateValue.saveType ) {
            case Types.UPDATE_OPTIONS:
                    handleUpdateOption();
                break;
            default:
        }
    }

    useEffect(() => {
        handleSave();
    }, [ stateValue.saveType ] );
    
    useEffect(() => {
        getTheOptins();
        getThePostTypes();
    }, [] );

    return (
            <Layout className="tttme-App" style={{
                padding: '10px',
                background: '#fff',
                borderRadius: '5px',
                boxShadow: '0 4px 40px rgb(0 0 0 / 5%)',
                height: 'calc( 100vh - 110px )',
            }}>
                <Sider style={{ borderRadius: '5px' }}>
                    <MainHeader/>
                </Sider>
                <Layout className="layout" style={{ padding: '10px', overflowY: 'auto' }} >
                    { 'settings' === stateValue.generalData.selectedMenu && <Settings/>  }
                    { 'needsupport' === stateValue.generalData.selectedMenu && <NeedSupport/> }
                </Layout>
            </Layout>
    );
}

export default App