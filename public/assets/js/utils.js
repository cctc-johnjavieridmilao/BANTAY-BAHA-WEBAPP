//AXIOS POST
post = function(url,data) {
   return new Promise((resolve,reject) => {
        if (typeof data === 'object') {
          send = JSON.stringify(data);
        }
        if (data instanceof FormData == true) {
          send = data;  
        }
         axios.post(url,send).then(function(res) {
           resolve(res.data);
         })
         .catch(function(err) {
         error = JSON.stringify(reject({
             Error: 'Error Posting Data',
             status: 500,
             Info: err
          }));
        
        throw new Error(error);
     })
   })
}

//AXIOS GET
get = function(url) {
   return new Promise((resolve,reject) => {

     axios.get(url).then(function(res) {
          resolve(res.data);
      })
     .catch(function(err) {
       error = JSON.stringify(reject({
           Error: 'Error Getting Data',
           status: 500,
           Info: err
        }));
        
        throw new Error(error);
     })
   })
}

//VIEW FILE

viewFiles = function(file, url) {

    var ext = file != null ? file.split('.').pop() : '';
    var image_ext = ['png','jpg','jpeg'];

    if (image_ext.includes(ext)) {
       return `${url}${file}`;
    }

    if (ext == 'pdf') {
        return `${url}${'pdflogo.png'}`;
    } else if (ext == 'docx') {
        return `${url}${'msdword1.png'}`;
    } else if (ext == 'xlsx') {
        return `${url}${'excelpng.png'}`;
    } else {
       return `${url}${'file.png'}`;
    }

}

