const path = require('path');
const glob = require('glob');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const VueLoaderPlugin = require('vue-loader').VueLoaderPlugin;
const webpack = require('webpack');

function globs(entries) {
    let result = [];
    for (let i = 0; i < entries.length; i++) {
        const pattern = entries[i];
        result = result.concat(glob.sync(pattern));
    }
    return result;
}

module.exports = {
    context: __dirname,
    entry: {
        'landing.css': ['./styles/landing.scss'],
        'site.css': globs([
            './libs/semantic/*.css',
            './styles/site.scss'
        ]),
        'asset.js': globs([
            './libs/semantic/*.js',
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
                test: /\.css$/,
                use: ExtractTextPlugin.extract({
                    use: [
                        'css-loader',
                        'resolve-url-loader',
                        
                    ]
                })
            },
            {
                test: /\.scss$/,
                include: path.resolve(__dirname, 'styles'),
                use: ExtractTextPlugin.extract({
                    use: [
                        'css-loader',
                        'resolve-url-loader',
                        {
                            loader: 'sass-loader',
                            options: {
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
        new VueLoaderPlugin(),

        // Semantic-Ui использует переменную jQuery, которая должна быть глобальной.
        // И предполагается, что сам Semantic тоже в глобальной области, но в нашем
        // случае он в модульной системе, и чтобы автоматически подгрузить модуль
        // jquery в переменную jQuery используем специальный плагин ProvidePlugin.
        new webpack.ProvidePlugin({
            jQuery: 'jquery'
        })
    ],
    resolve: {
        extensions: ['*', '.ts', '.tsx', '.js', '.jsx', '.vue'],
        alias: {
            vue$: 'vue/dist/vue.esm.js'
        }
    }
}