const path = require('path');
const glob = require('glob');
const onceImporter = require('node-sass-once-importer');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const VueLoaderPlugin = require('vue-loader').VueLoaderPlugin;
const process = require('process');

function globs(entries) {
    let result = [];
    for (let i = 0; i < entries.length; i++) {
        const pattern = entries[i];
        result = result.concat(glob.sync(pattern));
    }
    return result;
}

const mode = process.env.NODE_DEV === 'true' ? 'development' : 'production';
console.log('Webpack build in ' + mode + ' mode.');

module.exports = {
    context: __dirname,
    mode: mode,
    devtool: "source-map",
    entry: {
        'landing.css': ['./styles/landing.scss'],
        'site.css': ['./styles/site.scss'],
        'asset.js': globs([
            './scripts/apps/*.js',
            './scripts/apps/*.ts',
            './scripts/components/*.js'
        ])
    },
    output: {
        path: path.resolve(__dirname, './build'),
        filename: '[name]'
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                include: path.resolve(__dirname, 'styles'),
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: [
                        'css-loader',
                        'resolve-url-loader',
                        {
                            loader: 'sass-loader',
                            options: {
                                importer: onceImporter(),
                                sourceMap: true, // required by resolve-url-loader
                                sourceMapContents: false
                            }
                        }
                    ]
                })
            },
            {
                // Webpack не понимает @font-face в css без этого.
                test: /\.(png|jpg|jpeg|woff(2)?|eot|ttf|svg)$/,
                use: ['url-loader']
            },
            {
                test: /\.(ts|tsx)$/,
                use: [
                    'babel-loader', 
                    {
                        loader: 'ts-loader',
                        options: {
                            appendTsSuffixTo: [/\.vue$/]
                        }
                    }
                ],
            },
            {
                test: /\.(js|jsx)$/,
                use: ['babel-loader']
            },
            {
                test: /\.vue$/,
                use: ['vue-loader']
            },
            {
                test: /\.scss$/,
                include: path.resolve(__dirname, 'scripts'),
                use: [
                    'vue-style-loader',
                    'css-loader',
                    'resolve-url-loader',
                    'sass-loader'
                ]
            }
        ]
    },
    plugins: [
        new ExtractTextPlugin('[name]'),
        new VueLoaderPlugin()
    ],
    resolve: {
        extensions: ['*', '.ts', '.tsx', '.js', '.jsx', '.vue'],
        alias: {
            // Remove 'common' part in the production
            vue$: 'vue/dist/vue.common.js'
        }
    }
}