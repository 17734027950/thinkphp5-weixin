Page({
    data: {
        img: '',
        name: '',
        city: ''
    },
    onLoad () {
        wx.getUserInfo({
            success: res => {
                
        console.log(1)
                this.setData({
                    img: res.userInfo.avatarUrl,
                    name: res.userInfo.nickName,
                    city: res.userInfo.city
                })
            }
        })            
    }
})