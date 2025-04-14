import {defaultTheme} from '@vuepress/theme-default'
import {defineUserConfig} from 'vuepress'
import {viteBundler} from '@vuepress/bundler-vite'

export default defineUserConfig({
    theme: defaultTheme({
        logo: '/images/logo.webp',
        locales: {
            '/': {
                selectLanguageName: 'English',
                navbar: [
                    {text: 'Home', link: '/'},
                    {text: 'Documentation', link: '/introduction/installation'},
                    {text: 'GitHub', link: 'https://github.com/dependencies-packagist/jwt'},
                ],
                sidebar: [{
                    title: 'Introduction',
                    collapsable: true,
                    children: [
                        '/introduction/installation'
                    ]
                }, {
                    title: 'Usage',
                    collapsable: true,
                    children: [
                        '/usage/configuration',
                        '/usage/issuing-tokens',
                        '/usage/parsing-tokens',
                        '/usage/validating-tokens'
                    ]
                }, {
                    title: 'Guides',
                    collapsable: true,
                    children: [
                        '/guides/extending-the-library'
                    ]
                }]
            },
            '/zh/': {
                selectLanguageName: '简体中文',
                navbar: [
                    {text: '首页', link: '/zh/'},
                    {text: '文档', link: '/zh/introduction/installation'},
                    {text: 'GitHub', link: 'https://github.com/dependencies-packagist/jwt'},
                ],
                sidebar: [{
                    title: '简介',
                    collapsable: true,
                    children: [
                        '/zh/introduction/installation'
                    ]
                }, {
                    title: '指南',
                    collapsable: true,
                    children: [
                        '/zh/usage/configuration',
                        '/zh/usage/issuing-tokens',
                        '/zh/usage/parsing-tokens',
                        '/zh/usage/validating-tokens'
                    ]
                }, {
                    title: '参考',
                    collapsable: true,
                    children: [
                        '/zh/guides/extending-the-library'
                    ]
                }]
            },
        },
    }),
    locales: {
        // 键名是该语言所属的子路径
        // 作为特例，默认语言可以使用 '/' 作为其路径。
        '/': {
            lang: 'en-US',
            title: 'JSON Web Token',
            description: 'A simple library to work with JSON Web Token and JSON Web Signature.',
        },
        '/zh/': {
            lang: 'zh-CN',
            title: 'JSON Web Token',
            description: 'JSON Web Token 和 JSON Web Signature',
        },
    },

    bundler: viteBundler(),
})
