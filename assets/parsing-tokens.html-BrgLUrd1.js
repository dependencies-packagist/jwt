import{_ as s,c as a,a as e,o as p}from"./app-B9Ka1KbF.js";const t={};function o(c,n){return p(),a("div",null,n[0]||(n[0]=[e(`<h1 id="parsing-tokens" tabindex="-1"><a class="header-anchor" href="#parsing-tokens"><span>Parsing tokens</span></a></h1><p>To parse a token you must create a new parser and ask it to parse a string:</p><div class="language-php line-numbers-mode" data-highlighter="prismjs" data-ext="php"><pre><code><span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Parser</span><span class="token punctuation">;</span></span>
<span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Encoding<span class="token punctuation">\\</span>JoseEncoder</span><span class="token punctuation">;</span></span>
<span class="line"></span>
<span class="line"><span class="token variable">$parser</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">Parser</span><span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">JoseEncoder</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></span>
<span class="line"></span>
<span class="line"><span class="token variable">$token</span> <span class="token operator">=</span> <span class="token variable">$parser</span><span class="token operator">-&gt;</span><span class="token function">parse</span><span class="token punctuation">(</span></span>
<span class="line">    <span class="token string single-quoted-string">&#39;eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.&#39;</span></span>
<span class="line">    <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;eyJzdWIiOiIxMjM0NTY3ODkwIn0.&#39;</span></span>
<span class="line">    <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;2gSBz9EOsQRN9I-3iSxJoFt7NtgV6Rm0IL6a8CAwl3Q&#39;</span></span>
<span class="line"><span class="token punctuation">)</span><span class="token punctuation">;</span></span>
<span class="line"></span>
<span class="line"><span class="token function">var_dump</span><span class="token punctuation">(</span><span class="token variable">$token</span><span class="token operator">-&gt;</span><span class="token function">headers</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// Retrieves the token headers</span></span>
<span class="line"><span class="token function">var_dump</span><span class="token punctuation">(</span><span class="token variable">$token</span><span class="token operator">-&gt;</span><span class="token function">claims</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// Retrieves the token claims</span></span>
<span class="line"></span></code></pre><div class="line-numbers" aria-hidden="true" style="counter-reset:line-number 0;"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><blockquote><p>Important In case of parsing errors the Parser will throw an exception of type <code>InvalidArgumentException</code>.</p></blockquote>`,4)]))}const l=s(t,[["render",o]]),r=JSON.parse('{"path":"/usage/parsing-tokens.html","title":"Parsing tokens","lang":"en-US","frontmatter":{},"headers":[],"git":{"updatedTime":1744720143000,"contributors":[{"name":"jundayw","username":"jundayw","email":"jundayw@126.com","commits":1,"url":"https://github.com/jundayw"}],"changelog":[{"hash":"91a3d6fc9010e5c1bda03335ef85a5b0a234ba4f","time":1744720143000,"email":"jundayw@126.com","author":"jundayw","message":"docs"}]},"filePathRelative":"usage/parsing-tokens.md"}');export{l as comp,r as data};
