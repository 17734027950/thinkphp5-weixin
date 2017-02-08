const app = getApp();
Page({
    data: {
        movie: {}
    },
    onLoad (params) {
        console.log(params.id)
    },
    onReady () {
        wx.setNavigationBarTitle({title:'豆瓣 > 电影 > 速度与激情7'})
      },
})