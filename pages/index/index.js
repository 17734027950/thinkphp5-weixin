//index.js
//获取应用实例
const app = getApp()
Page({
  data: {
    movie: []
  },
  onLoad () {
    let params = {
      count: 3
    }
    app.fetch('coming_soon', params)
      .then( d => {
        this.setData({movie: d.data.subjects})
      }
    )
  },
  EventHandle: function(){
    wx.switchTab({
      url: '../board/board'
    })
  }
})
