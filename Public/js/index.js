/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
var app = {
    // Application Constructor
    initialize: function() {
        this.bindEvents();
    },
    // Bind Event Listeners
    //
    // Bind any events that are required on startup. Common events are:
    // 'load', 'deviceready', 'offline', and 'online'.
    bindEvents: function() {

        document.addEventListener('deviceready', this.onDeviceReady, false);
    },
    // deviceready Event Handler
    //
    // The scope of 'this' is the event. In order to call the 'receivedEvent'
    // function, we must explicitly call 'app.receivedEvent(...);'
    onDeviceReady: function() {
    }
};


//网络状态
function networkType(option) {
    if(trueurl != undefined){
        var bool =weburl.indexOf(trueurl);
        if(bool == 0){
            setTimeout(function() {
                jmportal.device.getNetworkType(function (data) {
                    option.success(data);
                }, function (data) {
                    option.fail('networkType error');
                });
            }, 500);

        }else{
            alert('配置权限失败，无法使用');
        }

    }else{
        alert('配置权限失败，无法使用');
    }
};
//用户注册（浙江为例）
function registerUser(option) {
    jmportal.login.registerUser(function (data) {
        option.success(data);

    }, function (data) {

        option.fail('RegisterUser error');
    });
};

//找回密码（浙江为例）
function modifyPassword(option) {
    jmportal.login.modifyPassword(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('ModifyPassword error');
    });
};

//获得用户信息
function getUserInfo(option){
    setTimeout( function () {
        jmportal.login.getUserInfo(function (data) {
            resultdata=data

            option.success(data);

        }, function (data) {
            option.fail('GetUserInfo error');
        });
    },1000);

}

//登录
function loginApp(option) {
    jmportal.login.loginApp(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('LoginApp error');
    });

};

//注销
function logout(option) {
    jmportal.login.logout(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('Logout error');
    });

};
//登录到qq
function loginQQ(option) {
    jmportal.login.loginQQ(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('login QQ error');
    });
};
//注销qq
function logoutQQ(option) {
    jmportal.login.logoutQQ(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('logout QQ error');
    });
};
//登录到腾讯微博
function loginTencentWeibo(option) {
    jmportal.login.loginTencentWeibo(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('login TencentWeibo error');
    });
};
//注销腾讯微博
function logoutTencentWeibo(option) {
    jmportal.login.logoutTencentWeibo(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('logout TencentWeibo error');
    });
};
//登录到新浪微博
function loginSinaWeibo(option) {
    jmportal.login.loginSinaWeibo(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('login SinaWeibo error');
    });
};
//注销新浪微博
function logoutSinaWeibo(option) {
    jmportal.login.logoutSinaWeibo(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('logout SinaWeibo error');
    });
};

//获得设备唯一标示
function getUUID(option) {
    setTimeout( function () {
        jmportal.device.getUUID(function (data) {
            option.success(data);
        }, function (data) {
            option.fail('UUID error');
        });
    },500);
};

//计算距离
function getDistance(option) {
    setTimeout( function () {
        jmportal.device.getDistance(function (data) {
            option.success(data);
        }, function (data) {
            option.fail('getDistance error');
        },option.arg);
    },500);
};

//获得坐标
function getlocation(option) {
    setTimeout( function () {
        jmportal.device.getLocation(function (data) {
            option.success(data);
        }, function (data) {
            option.fail('location error');
        });
    },500);
};

//选取图片
function chooseImage(option) {
    jmportal.camera.chooseImage(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('choose image error');
    },option.arg,'jssdk1.3');
};
//选取视频
function chooseVideo(option) {
    jmportal.video.getVideo(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('getVideo error');
    },'jssdk1.3');
};
//综合媒体
function chooseVideoAndPic(option) {
    jmportal.camera.chooseVideoAndPic(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('choose VideoAndPic error');
    },'jssdk1.3');
}

//音频
function startVoice(option) {
    jmportal.voice.startVoice(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('start voice error');
    },'jssdk1.3');
};

function stopVoice(option) {
    jmportal.voice.stopVoice(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('start voice error');
    },'jssdk1.3');
};

function playVoice(option) {
    jmportal.voice.playVoice(function (data){
        option.success(data);
    }, function (data) {
        option.fail('play voice error');
    },option.audio,'jssdk1.3');//传入要播放的音频文件的路径
};
function stopPlayVoice(option) {
    jmportal.voice.stopPlayVoice(function (data){
        option.success(data);
    }, function (data) {
        option.fail('stopPlayVoice voice error');
    },'jssdk1.3');
};

//二维码
function getQRCode(option) {
    jmportal.QRCode.getQRCode(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('QRCode error');
    });
};
//分享
function share(option) {
    jmportal.share.onMenuShare(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('share error');
    },option.arg);//传入分享的参数
};
//支付
function pay(option) {
    jmportal.pay.pay(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('pay error');
    },option.orderNum,option.goodName,option.allPrice,option.orderTime,option.payType);
};
//保存数据
function setItem(option) {
    jmportal.storage.setItem(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('setItem error');
    },option.key,option.value);

};

//读取数据
function getItem(option) {

    jmportal.storage.getItem(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('getItem error');
    },option.key);
};
//删除数据
function removeItem(option) {
    jmportal.storage.removeItem(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('removeItem error');
    },option.key);
};
//页面控制
function showOrHiddenNav(option) {
    jmportal.showOrHiddenNav.showOrHiddenNav(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('showNav error');
    },option.key1,option.key2,option.key3,option.key4);
};
//提交
function submit(option) {
    jmportal.upload.onSubmit(function (data) {
        option.success(data);
    }, function (data) {
        alert("upload error");
        option.fail('upload error');
    },option.url,option.key1,option.key2,option.key3,option.key4);
};

//打电话
function callPhone(option) {
    jmportal.communication.callPhone(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('callPhone error');
    },option.phone);
};//发短信
function sendMessage(option) {
    jmportal.communication.sendMessage(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('sendMessage error');
    },option.phone);
};//发邮件
function sendEmail(option) {
    jmportal.communication.sendEmail(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('sendMessage error');
    },option.email);
};
//人脸认证
function faceIdentification(option) {
    jmportal.identification.faceIdentification(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('faceIdentification error');
    },option.userId);
};
//支付宝认证
function alipayIdentification(option) {
    jmportal.identification.alipayIdentification(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('alipayIdentification error');
    });
};

//关闭当前窗口
function closeWindow(option) {
    jmportal.showOrHiddenNav.closeWindow(function (data) {
        option.success(data);
    }, function (data) {
        option.fail('getDistance error');
    });
};

//旧的

//页面控制
function onShowOrHiddenNav(arg0,arg1,arg2,arg3) {
    jmportal.showOrHiddenNav.showOrHiddenNav(function (data) {
        alert(data);
    }, function (data) {
        alert("showNav error");
    },arg0,arg1,arg2,arg3);
};


function config(key,secret) {
    var urlcan = window.location.href;
    var url = 'http://192.168.89.173:8081/jmopen1.0/interfaces/checklightvalid.do';
    $.ajax(url, {
        data: {'urlString':urlcan,
            'key':key,
            'secret':secret,
        },
        dataType: 'json', //服务器返回json格式数据
        type: 'post', //HTTP请求类型
        async: false, //同步
        timeout: 10000, //超时时间设置为10秒；
        success: function(data) {
            var  result = data.isvalid;
            if(result == "false") {
                alert('验证失败，error：'+data.code);
            } else {
                trueurl =data.urldomain;
            }
        },
        error:function(e){
            alert('cuowu'+e);
            alert('cuowu'+e.errmsg);
        }
    });
};
var trueurl;
var weburl = window.location.href;
app.initialize();
