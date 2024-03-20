import jQuery from "jquery";

class APIRequest {
  static get_news_data( params = "", endpoint = "posts" ) {

    const getUrl = `https://stories.butler.edu/wp-json/wp/v2/${ endpoint }?${ params }&_embed&_envelope`;

    console.log( getUrl );

    jQuery.ajax({
      url: getUrl,
      method: 'GET',
      success: function ( html ) {
        alert( JSON.stringify( html ) );
      },
    });
  }
}

export default APIRequest;