import{_ as i,c as o,a as t,b as l,d as s,e,w as p,r as c,o as u}from"./app-B9Ka1KbF.js";const r={};function d(k,n){const a=c("RouteLink");return u(),o("div",null,[n[19]||(n[19]=t(`<h1 id="扩展指南" tabindex="-1"><a class="header-anchor" href="#扩展指南"><span>扩展指南</span></a></h1><p>我们在此库中设计了一些扩展点。 这些扩展点应该能够让用户根据需要轻松定制我们的核心组件。</p><h2 id="令牌构建器" tabindex="-1"><a class="header-anchor" href="#令牌构建器"><span>令牌构建器</span></a></h2><p>令牌构建器定义了一个用于创建普通令牌的流畅接口。 要创建您自己的令牌构建器，您必须实现 <code>Token\\JWT\\Contracts\\Builder</code> 接口：</p><div class="language-php line-numbers-mode" data-highlighter="prismjs" data-ext="php"><pre><code><span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Builder</span><span class="token punctuation">;</span></span>
<span class="line"></span>
<span class="line"><span class="token keyword">final</span> <span class="token keyword">class</span> <span class="token class-name-definition class-name">MyCustomTokenBuilder</span> <span class="token keyword">implements</span> <span class="token class-name">Builder</span></span>
<span class="line"><span class="token punctuation">{</span></span>
<span class="line">    <span class="token comment">// implement all methods</span></span>
<span class="line"><span class="token punctuation">}</span></span>
<span class="line"></span></code></pre><div class="line-numbers" aria-hidden="true" style="counter-reset:line-number 0;"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,5)),l("p",null,[n[1]||(n[1]=s("然后，在 ")),e(a,{to:"/zh/usage/configuration.html"},{default:p(()=>n[0]||(n[0]=[s("配置")])),_:1}),n[2]||(n[2]=s(" 中注册一个自定义工厂："))]),n[20]||(n[20]=t(`<div class="language-php line-numbers-mode" data-highlighter="prismjs" data-ext="php"><pre><code><span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Builder</span><span class="token punctuation">;</span></span>
<span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>ClaimsFormatter</span><span class="token punctuation">;</span></span>
<span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Token</span><span class="token punctuation">;</span></span>
<span class="line"></span>
<span class="line"><span class="token variable">$token</span><span class="token operator">-&gt;</span><span class="token function">setBuilderFactory</span><span class="token punctuation">(</span></span>
<span class="line">    <span class="token keyword">static</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token class-name type-declaration">ClaimsFormatter</span> <span class="token variable">$formatter</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token class-name return-type">Builder</span> <span class="token punctuation">{</span></span>
<span class="line">        <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">MyCustomTokenBuilder</span><span class="token punctuation">(</span><span class="token variable">$formatter</span><span class="token punctuation">)</span><span class="token punctuation">;</span></span>
<span class="line">    <span class="token punctuation">}</span></span>
<span class="line"><span class="token punctuation">)</span><span class="token punctuation">;</span></span>
<span class="line"></span></code></pre><div class="line-numbers" aria-hidden="true" style="counter-reset:line-number 0;"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="格式处理器" tabindex="-1"><a class="header-anchor" href="#格式处理器"><span>格式处理器</span></a></h2><p>默认情况下，JWT 声明格式处理器功能包括：</p><ul><li>统一 aud（audience，受众）声明：当该声明中只有一个项时，确保它是一个字符串，而不是数组</li><li>使用微秒（浮点数）格式化日期类型的声明</li></ul><p>你也可以自定义甚至创建你自己的格式化器。</p><div class="language-php line-numbers-mode" data-highlighter="prismjs" data-ext="php"><pre><code><span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>ClaimsFormatter</span><span class="token punctuation">;</span></span>
<span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>RegisteredClaims</span><span class="token punctuation">;</span></span>
<span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Token</span><span class="token punctuation">;</span></span>
<span class="line"></span>
<span class="line"><span class="token keyword">final</span> <span class="token keyword">class</span> <span class="token class-name-definition class-name">UnixTimestampDates</span> <span class="token keyword">implements</span> <span class="token class-name">ClaimsFormatter</span></span>
<span class="line"><span class="token punctuation">{</span></span>
<span class="line">    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">formatClaims</span><span class="token punctuation">(</span><span class="token keyword type-hint">array</span> <span class="token variable">$claims</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span></span>
<span class="line">    <span class="token punctuation">{</span></span>
<span class="line">        <span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token class-name static-context">RegisteredClaims</span><span class="token operator">::</span><span class="token constant">DATE_CLAIMS</span> <span class="token keyword">as</span> <span class="token variable">$claim</span><span class="token punctuation">)</span> <span class="token punctuation">{</span></span>
<span class="line">            <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token operator">!</span> <span class="token function">array_key_exists</span><span class="token punctuation">(</span><span class="token variable">$claim</span><span class="token punctuation">,</span> <span class="token variable">$claims</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span></span>
<span class="line">                <span class="token keyword">continue</span><span class="token punctuation">;</span></span>
<span class="line">            <span class="token punctuation">}</span></span>
<span class="line"></span>
<span class="line">            <span class="token function">assert</span><span class="token punctuation">(</span><span class="token variable">$claims</span><span class="token punctuation">[</span><span class="token variable">$claim</span><span class="token punctuation">]</span> <span class="token keyword">instanceof</span> <span class="token class-name">DateTimeImmutable</span><span class="token punctuation">)</span><span class="token punctuation">;</span></span>
<span class="line">            <span class="token variable">$claims</span><span class="token punctuation">[</span><span class="token variable">$claim</span><span class="token punctuation">]</span> <span class="token operator">=</span> <span class="token variable">$claims</span><span class="token punctuation">[</span><span class="token variable">$claim</span><span class="token punctuation">]</span><span class="token operator">-&gt;</span><span class="token function">getTimestamp</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span></span>
<span class="line">        <span class="token punctuation">}</span></span>
<span class="line"></span>
<span class="line">        <span class="token keyword">return</span> <span class="token variable">$claims</span><span class="token punctuation">;</span></span>
<span class="line">    <span class="token punctuation">}</span></span>
<span class="line"><span class="token punctuation">}</span></span>
<span class="line"></span>
<span class="line"><span class="token variable">$token</span><span class="token operator">-&gt;</span><span class="token function">builder</span><span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">UnixTimestampDates</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></span>
<span class="line"></span></code></pre><div class="line-numbers" aria-hidden="true" style="counter-reset:line-number 0;"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p><code>Token\\JWT\\Contracts\\ChainedFormatter</code> 允许用户组合多个声明格式处理器。</p><h2 id="令牌解析器" tabindex="-1"><a class="header-anchor" href="#令牌解析器"><span>令牌解析器</span></a></h2><p>令牌解析器定义了应如何将 JWT 字符串转换为令牌对象。 要创建你自己的解析器，你必须实现 <code>Token\\JWT\\Parser</code> 接口。</p><div class="language-php line-numbers-mode" data-highlighter="prismjs" data-ext="php"><pre><code><span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Parser</span><span class="token punctuation">;</span></span>
<span class="line"></span>
<span class="line"><span class="token keyword">final</span> <span class="token keyword">class</span> <span class="token class-name-definition class-name">MyCustomTokenParser</span> <span class="token keyword">implements</span> <span class="token class-name">Parser</span></span>
<span class="line"><span class="token punctuation">{</span></span>
<span class="line">    <span class="token comment">// implement all methods</span></span>
<span class="line"><span class="token punctuation">}</span></span>
<span class="line"></span></code></pre><div class="line-numbers" aria-hidden="true" style="counter-reset:line-number 0;"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,10)),l("p",null,[n[4]||(n[4]=s("然后在 ")),e(a,{to:"/zh/usage/configuration.html"},{default:p(()=>n[3]||(n[3]=[s("配置")])),_:1}),n[5]||(n[5]=s(" 中注册一个实例："))]),n[21]||(n[21]=t(`<div class="language-php line-numbers-mode" data-highlighter="prismjs" data-ext="php"><pre><code><span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Token</span><span class="token punctuation">;</span></span>
<span class="line"></span>
<span class="line"><span class="token variable">$token</span><span class="token operator">-&gt;</span><span class="token function">setParser</span><span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">MyCustomTokenParser</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></span>
<span class="line"></span></code></pre><div class="line-numbers" aria-hidden="true" style="counter-reset:line-number 0;"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="签名器" tabindex="-1"><a class="header-anchor" href="#签名器"><span>签名器</span></a></h2><p>签名器定义了如何生成和验证签名。 如果你想自定义签名器，则必须实现 <code>Token\\JWT\\Contracts\\Signer</code> 接口。</p><div class="language-php line-numbers-mode" data-highlighter="prismjs" data-ext="php"><pre><code><span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Signer</span><span class="token punctuation">;</span></span>
<span class="line"></span>
<span class="line"><span class="token keyword">final</span> <span class="token keyword">class</span> <span class="token class-name-definition class-name">SignerForAVeryCustomizedAlgorithm</span> <span class="token keyword">implements</span> <span class="token class-name">Signer</span></span>
<span class="line"><span class="token punctuation">{</span></span>
<span class="line">    <span class="token comment">// implement all methods</span></span>
<span class="line"><span class="token punctuation">}</span></span>
<span class="line"></span></code></pre><div class="line-numbers" aria-hidden="true" style="counter-reset:line-number 0;"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,4)),l("p",null,[n[9]||(n[9]=s("然后在创建 ")),e(a,{to:"/zh/usage/configuration.html"},{default:p(()=>n[6]||(n[6]=[s("配置")])),_:1}),n[10]||(n[10]=s("、")),e(a,{to:"/zh/usage/issuing-tokens.html"},{default:p(()=>n[7]||(n[7]=[s("发放令牌")])),_:1}),n[11]||(n[11]=s(" 或 ")),e(a,{to:"/zh/usage/validating-tokens.html"},{default:p(()=>n[8]||(n[8]=[s("解析令牌")])),_:1}),n[12]||(n[12]=s(" 实例时传递它的一个实例。"))]),n[22]||(n[22]=t(`<h2 id="密钥对象" tabindex="-1"><a class="header-anchor" href="#密钥对象"><span>密钥对象</span></a></h2><p>密钥对象会被传递给签名器，并提供生成和验证签名所需的信息。 如果你想自定义密钥对象，则必须实现 <code>Token\\JWT\\Contracts\\Key</code> 接口。</p><div class="language-php line-numbers-mode" data-highlighter="prismjs" data-ext="php"><pre><code><span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Key</span><span class="token punctuation">;</span></span>
<span class="line"></span>
<span class="line"><span class="token keyword">final</span> <span class="token keyword">class</span> <span class="token class-name-definition class-name">KeyWithSomeMagicalProperties</span> <span class="token keyword">implements</span> <span class="token class-name">Key</span></span>
<span class="line"><span class="token punctuation">{</span></span>
<span class="line">    <span class="token comment">// implement all methods</span></span>
<span class="line"><span class="token punctuation">}</span></span>
<span class="line"></span></code></pre><div class="line-numbers" aria-hidden="true" style="counter-reset:line-number 0;"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="令牌验证器" tabindex="-1"><a class="header-anchor" href="#令牌验证器"><span>令牌验证器</span></a></h2><p>令牌验证器定义了如何应用验证约束，以对令牌进行验证或断言。 如果你想自定义验证器，则必须实现 <code>Token\\JWT\\Contracts\\Validator</code> 接口。</p><div class="language-php line-numbers-mode" data-highlighter="prismjs" data-ext="php"><pre><code><span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Validator</span><span class="token punctuation">;</span></span>
<span class="line"></span>
<span class="line"><span class="token keyword">final</span> <span class="token keyword">class</span> <span class="token class-name-definition class-name">MyCustomTokenValidator</span> <span class="token keyword">implements</span> <span class="token class-name">Validator</span></span>
<span class="line"><span class="token punctuation">{</span></span>
<span class="line">    <span class="token comment">// implement all methods</span></span>
<span class="line"><span class="token punctuation">}</span></span>
<span class="line"></span></code></pre><div class="line-numbers" aria-hidden="true" style="counter-reset:line-number 0;"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,6)),l("p",null,[n[14]||(n[14]=s("然后在 ")),e(a,{to:"/zh/usage/configuration.html"},{default:p(()=>n[13]||(n[13]=[s("配置")])),_:1}),n[15]||(n[15]=s(" 中注册一个实例："))]),n[23]||(n[23]=t(`<div class="language-php line-numbers-mode" data-highlighter="prismjs" data-ext="php"><pre><code><span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Token</span><span class="token punctuation">;</span></span>
<span class="line"></span>
<span class="line"><span class="token variable">$token</span><span class="token operator">-&gt;</span><span class="token function">setValidator</span><span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">MyCustomTokenValidator</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></span>
<span class="line"></span></code></pre><div class="line-numbers" aria-hidden="true" style="counter-reset:line-number 0;"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="验证约束集合" tabindex="-1"><a class="header-anchor" href="#验证约束集合"><span>验证约束集合</span></a></h2><p>验证约束定义了应如何验证一个或多个声明（claims）或头部（headers）。 自定义验证约束非常适合为注册声明提供高级验证规则，或用于验证私有声明。 如果你想自定义验证约束，则必须实现 <code>Token\\JWT\\Contracts\\Constraint</code> 接口。</p><div class="language-php line-numbers-mode" data-highlighter="prismjs" data-ext="php"><pre><code><span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Token</span><span class="token punctuation">;</span></span>
<span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Constraint</span><span class="token punctuation">;</span></span>
<span class="line"><span class="token keyword">use</span> <span class="token package">Token<span class="token punctuation">\\</span>JWT<span class="token punctuation">\\</span>Exceptions<span class="token punctuation">\\</span>ConstraintViolationException</span><span class="token punctuation">;</span></span>
<span class="line"></span>
<span class="line"><span class="token keyword">final</span> <span class="token keyword">class</span> <span class="token class-name-definition class-name">SubjectMustBeAValidUser</span> <span class="token keyword">implements</span> <span class="token class-name">Constraint</span></span>
<span class="line"><span class="token punctuation">{</span></span>
<span class="line">    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">assert</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Token</span> <span class="token variable">$token</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">void</span></span>
<span class="line">    <span class="token punctuation">{</span></span>
<span class="line">        <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token operator">!</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">existsInDatabase</span><span class="token punctuation">(</span><span class="token variable">$token</span><span class="token operator">-&gt;</span><span class="token function">claims</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;sub&#39;</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span></span>
<span class="line">            <span class="token keyword">throw</span> <span class="token keyword">new</span> <span class="token class-name">ConstraintViolationException</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;Token related to an unknown user&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span></span>
<span class="line">        <span class="token punctuation">}</span></span>
<span class="line">    <span class="token punctuation">}</span></span>
<span class="line"></span>
<span class="line">    <span class="token keyword">private</span> <span class="token keyword">function</span> <span class="token function-definition function">existsInDatabase</span><span class="token punctuation">(</span><span class="token keyword type-hint">string</span> <span class="token variable">$userId</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">bool</span></span>
<span class="line">    <span class="token punctuation">{</span></span>
<span class="line">        <span class="token comment">// ...</span></span>
<span class="line">    <span class="token punctuation">}</span></span>
<span class="line"><span class="token punctuation">}</span></span>
<span class="line"></span></code></pre><div class="line-numbers" aria-hidden="true" style="counter-reset:line-number 0;"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,4)),l("p",null,[n[17]||(n[17]=s("然后在 ")),e(a,{to:"/zh/usage/validating-tokens.html"},{default:p(()=>n[16]||(n[16]=[s("验证令牌")])),_:1}),n[18]||(n[18]=s(" 时使用它。"))])])}const v=i(r,[["render",d]]),b=JSON.parse('{"path":"/zh/guides/extending-the-library.html","title":"扩展指南","lang":"zh-CN","frontmatter":{},"headers":[{"level":2,"title":"令牌构建器","slug":"令牌构建器","link":"#令牌构建器","children":[]},{"level":2,"title":"格式处理器","slug":"格式处理器","link":"#格式处理器","children":[]},{"level":2,"title":"令牌解析器","slug":"令牌解析器","link":"#令牌解析器","children":[]},{"level":2,"title":"签名器","slug":"签名器","link":"#签名器","children":[]},{"level":2,"title":"密钥对象","slug":"密钥对象","link":"#密钥对象","children":[]},{"level":2,"title":"令牌验证器","slug":"令牌验证器","link":"#令牌验证器","children":[]},{"level":2,"title":"验证约束集合","slug":"验证约束集合","link":"#验证约束集合","children":[]}],"git":{"updatedTime":1744720143000,"contributors":[{"name":"jundayw","username":"jundayw","email":"jundayw@126.com","commits":1,"url":"https://github.com/jundayw"}],"changelog":[{"hash":"91a3d6fc9010e5c1bda03335ef85a5b0a234ba4f","time":1744720143000,"email":"jundayw@126.com","author":"jundayw","message":"docs"}]},"filePathRelative":"zh/guides/extending-the-library.md"}');export{v as comp,b as data};
