/**
 * PartsVia Remote shopping API.
 *
 * This library interacts directly with the PartsVia shopping cart.
 * The setting to allow cross server transactions must be enabled in order for
 * These functions to work if you would like to add these functions to your site
 * Please visit: http://partsvia.com
 * @link   http://www.partsvia.com
 */

var PartsVia = PartsVia || {};

(function ($) {
    PartsVia.Cart = {
        config: {
            option: 'setting',
            storeURL: 'https://www.blueoxstore.com',
            service: '/b2c/remotecart/',
            errors: {
                generic: 'Unable to use this function at this time.',
                invalidBrowser: 'Sorry, but your web browser is not supported for this function',
                serviceError: 'Unable to connect to the remote shopping cart.'
            }
        },

        /**
         * Get Cart Summary
         * Returns a small summary of the current shopping cart.
         */
        getCartSummary: function () {
            return new Promise(function (resolve, reject) {
                var p = PartsVia.Cart,
                  c = p.config,
                  u = c.storeURL + c.service;
                var url = u + 'getshoppingcart/';
                p.remoteCartRequest('GET', url).then(function (res) {
                    resolve(JSON.parse(res));
                },
                  function (e) {
                      reject({
                          status: e.status,
                          statusText: e.statusText
                      });
                  }
                );
            });
        },

        /**
         * Add To Cart
         * Adds a product to the shopping cart remotely.
         * @param {any} productId 
         * @param {int} qty 
         */
        addToCart: function (productId, qty) {
            return new Promise(function (resolve, reject) {
                var p = PartsVia.Cart,
                  c = p.config,
                  u = c.storeURL + c.service;
                var url = u + 'addproducttocart/' + productId + '/' + qty;
                p.remoteCartRequest('GET', url).then(function (res) {
                    resolve(JSON.parse(res));
                },
                  function (e) {
                      reject({
                          status: e.status,
                          statusText: e.statusText
                      });
                  }
                );
            });
        },

        /**
         * Product Availability
         * Checks to see if the requested product is in stock.
         * or if the product can be special ordered.
         * @param {any} productId 
         */
        availability: function (productId) {
            return new Promise(function (resolve, reject) {
                var p = PartsVia.Cart,
                  c = p.config,
                  u = c.storeURL + c.service;

                var url = u + 'availability/' + productId + '/';
                p.remoteCartRequest('GET', url).then(function (res) {
                    resolve(JSON.parse(res));
                },
                  function (e) {
                      reject({
                          status: e.status,
                          statusText: e.statusText
                      });
                  }
                );
            });
        },

        /**
         * Builds and sends the XDR request
         * @param {*} method POST or GET
         * @param {*} url The url of the partsvia service.
         */
        remoteCartRequest: function (method, url) {
            return new Promise(function (resolve, reject) {
                var xhr = new XMLHttpRequest();
                if ("withCredentials" in xhr) {
                    xhr.open(method, url, true);
                    xhr.withCredentials = true;
                } else if (typeof XDomainRequest != "undefined") {
                    xhr.open(method, url);
                } else {
                    xhr = null;
                }

                xhr.onload = function () {
                    if (this.status >= 200 && this.status < 300) {
                        resolve(xhr.response);
                    } else {
                        reject({
                            status: this.status,
                            statusText: xhr.statusText
                        });
                    }
                };

                xhr.onerror = function () {
                    reject({
                        status: this.status,
                        statusText: PartsVia.Cart.config.errors.generic
                });
                };
                xhr.send();
            });
        }
    }
}
)(jQuery);
