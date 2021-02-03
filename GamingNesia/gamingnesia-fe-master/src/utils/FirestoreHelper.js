import { storage } from '@/main'

class FirestoreHelper {
  static uploadImage ({ image, metadata, onSuccess, onError }) {
    return new Promise((resolve, reject) => {
      storage
        .child('images/' + image.name)
        .put(image, metadata)
        .then(snapshot => {
          snapshot.ref.getDownloadURL().then((downloadUrl) => {
            onSuccess(snapshot, downloadUrl)

            resolve(snapshot)
          })
        })
        .catch(err => {
          onError(err)

          reject(snapshot)
        })
    })
  }
}

export default FirestoreHelper