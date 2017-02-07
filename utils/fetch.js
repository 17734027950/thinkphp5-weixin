import Promise from './promise.js'
const api = 'https://api.douban.com/v2/movie'

export default function fetch (path, params){
  return new Promise((resolve, reject) => {
    wx.request({
      url: `${api}/${path}`,
      data: params,
      method: 'GET', 
      header: {  
        'content-type': 'json'
      }, 
      success: resolve,
      fail: reject
    })
  })
}