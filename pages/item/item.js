const app = getApp();
Page({
    data: {
        movie: {}
    },
    onLoad (params) {
        app.fetch(`subject/${params.id}`)
            .then( res => {
                this.setData({movie:res.data});
                wx.setNavigationBarTitle({
                    title: `豆瓣 > 电影 > ${this.data.movie.title}`
                })
            })
    },
    onReady () {
        
    },
})