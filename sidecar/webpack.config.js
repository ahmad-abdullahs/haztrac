/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

const webpack = require('webpack');
const path = require('path');

const devMode = process.env.DEV;

module.exports = {
    mode: devMode ? 'development' : 'production',
    optimization: {
        minimize: !devMode,
    },
    devtool: 'source-map',
    entry: {
        sidecar: [
            'entry.js',
        ],
    },
    module: {
        rules: [{
            test: /\.js$/,
            exclude: /node_modules/,
            use: [{
                loader: 'babel-loader',
                options: {
                    presets: [
                        ['env', {
                            targets: {
                                browsers: [
                                    'last 1 chrome version',
                                    'last 1 firefox version',
                                    'last 1 safari version',
                                    'last 1 edge version',
                                    'ie 11',
                                ],
                            },
                        }],
                    ],
                },
            }],
        }],
    },
    output: {
        path: path.resolve(__dirname, 'minified'),
        filename: '[name].min.js',
        sourceMapFilename: '[name].min.js.map',

        // map the path correctly to avoid being inside of webpack://
        devtoolModuleFilenameTemplate: 'sidecar:///[resourcePath]',
        devtoolFallbackModuleFilenameTemplate: 'sidecar:///[resourcePath]?[hash]',
    },
    plugins: ([
        new webpack.DefinePlugin({
            ZEPTO: 'false',
        })]
    ),
    resolve: {
        modules: [
            path.join(__dirname, 'src'),
            path.join(__dirname, 'lib'),
            path.join(__dirname, 'node_modules'),
        ],
    },
};
