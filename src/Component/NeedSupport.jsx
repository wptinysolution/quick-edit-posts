import React from 'react';

import { useStateValue } from '../Utils/StateProvider';

import Loader from '../Utils/Loader';

import {
    Form,
    Input,
    Layout,
    Button,
    Divider,
    Checkbox,
    Typography
} from 'antd';

const { Content } = Layout;

const { Title, Paragraph  } = Typography;

function NeedSupport() {

    const [stateValue, dispatch] = useStateValue();

    return (
        <Layout style={{ position: 'relative' }}>
            <Content style={{
                padding: '150px',
                background: 'rgb(255 255 255 / 35%)',
                borderRadius: '5px',
                boxShadow: 'rgb(0 0 0 / 1%) 0px 0 20px',
            }}>
                <Content style={{  }}>
                    <Title level={5} style={{ margin:'0 0 15px 0', fontSize: '20px'}}> For faster support please send detail of your issue.</Title>

                    <Paragraph type="secondary" style={{ fontSize: '18px'}}>
                        <a  href={`https://wordpress.org/support/plugin/quick-edit-posts/`} target={`_blank`} > Contact Support </a>
                    </Paragraph>
                    {/*<Paragraph type="secondary" style={{ fontSize: '18px'}}>*/}
                    {/*    This will create a ticket. We will response form there.*/}
                    {/*</Paragraph >*/}
                    <Paragraph type="secondary" style={{ fontSize: '18px'}}>
                        Check our  <a href={`https://profiles.wordpress.org/wpdevit/#content-plugins`} target={`_blank`}> Plugins List </a>
                    </Paragraph>
                </Content>
            </Content>
        </Layout>

    );
};

export default NeedSupport;