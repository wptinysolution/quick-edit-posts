import React from 'react';

import { useStateValue } from '../Utils/StateProvider';

import Loader from '../Utils/Loader';

import {
    Form,
    Layout,
    Button,
    Input,
    Divider,
    Typography,
    Checkbox,
    Col,
    Row,
} from 'antd';

const { TextArea } = Input;

const { Content } = Layout;

const { Paragraph, Text } = Typography;

import * as Types from "../Utils/actionType";

function Settings() {

    const [stateValue, dispatch] = useStateValue();

    const onChange = (checkedValues) => {
        dispatch({
            type: Types.UPDATE_OPTIONS,
            options: {
                ...stateValue.options,
                selected_post_types: checkedValues
            }
        });
    };

    const is_pro = ( value ) => {
        const pro_type = [
            'product',
            'attachment'
        ]
        return pro_type.includes(value);
    };

    return (
        <Layout style={{ position: 'relative' }}>
            <Form
                labelCol={{
                    span: 5,
                    offset: 0,
                    style:{
                        textAlign: 'left',
                    }
                }}
                wrapperCol={{ span: 12 }}
                layout="horizontal"
                style={{
                    maxWidth: 900,
                    padding: '15px',
                    height: '100%'
                }}
            >

                { stateValue.options.isLoading ? <Loader/> :
                    <Content style={{
                        padding: '15px',
                        borderRadius: '5px',
                        boxShadow: 'rgb(0 0 0 / 1%) 0px 0 20px',
                    }}>
                        <>
                            <div className="gutter-row" style={{marginBottom: '15px'}}>
                                <Row>
                                    <Col span={5}>
                                       Support Posts Type
                                    </Col>
                                    <Col span={19}>
                                        <Checkbox.Group
                                            style={{
                                                width: '100%',
                                            }}
                                            onChange={onChange}
                                            value={stateValue.options.selected_post_types}
                                        >
                                        {
                                            stateValue.generalData.postTypes.map( option => (
                                                <Col key={option.value} span={24}>
                                                    <Checkbox value={option['value']}>
                                                        {option['label']}
                                                        { is_pro(option.value) ? <span style={ { color: '#ff0000', fontWeight: 'bold', fontSize: '14px' } }> PRO</span> : '' }
                                                    </Checkbox>
                                                </Col>
                                            ))
                                        }
                                        </Checkbox.Group>
                                        <Text
                                            type="secondary"
                                        >
                                            This is example field
                                        </Text>

                                    </Col>
                                </Row>


                            </div>
                            <Divider/>

                        </>

                    </Content>
                }

            </Form>
            <Button
                type="primary"
                size="large"
                style={{
                    position: 'fixed',
                    bottom: '100px',
                    right: '100px'
                }}
                onClick={() => dispatch({
                    ...stateValue,
                    type: Types.UPDATE_OPTIONS,
                    saveType: Types.UPDATE_OPTIONS,
                })}>
                Save Settings
            </Button>
        </Layout>

    );
};

export default Settings;