<?php if (!defined('W3TC')) die(); ?>
<?php include W3TC_INC_DIR . '/options/common/header.php'; ?>

<p>
	本插件由<a href="http://www.jianhui.org" target="_blank"><strong>Jeff</strong></a>汉化，欢迎前往<a href="http://www.jianhui.org" target="_blank"><strong>Jeff的阳台</strong></a>。
	</br>插件状态目前是： <span class="w3tc-<?php if ($enabled): ?>enabled">启用<?php else: ?>disabled">disabled<?php endif; ?></span>如果有任何一个选项被禁用，意味着你当前的插件不兼容或插件需要重新安装。
</p>

<form action="admin.php?page=<?php echo $this->_page; ?>" method="post">
    <p>
    	选择
    	<input type="button" class="button button-self-test {nonce: '<?php echo wp_create_nonce('w3tc'); ?>'}" value="执行兼容性检查" />,
        <?php echo $this->nonce_field('w3tc'); ?>
    	<input class="button" type="submit" name="w3tc_flush_all" value="清空所有的缓存"<?php if (! $can_empty_memcache && ! $can_empty_opcode && ! $can_empty_file): ?> disabled="disabled"<?php endif; ?> /> 或者
    	<input class="button" type="submit" name="w3tc_flush_memcached" value="只清空分布式缓存"<?php if (! $can_empty_memcache): ?> disabled="disabled"<?php endif; ?> /> 或者
    	<input class="button" type="submit" name="w3tc_flush_opcode" value="只清空之前操作产生的缓存"<?php if (! $can_empty_opcode): ?> disabled="disabled"<?php endif; ?> /> 或者
    	<input class="button" type="submit" name="w3tc_flush_file" value="清空所有的磁盘缓存"<?php if (! $can_empty_file): ?> disabled="disabled"<?php endif; ?> />.
    </p>
</form>

<form action="admin.php?page=<?php echo $this->_page; ?>" method="post">
    <div class="metabox-holder">
        <?php echo $this->postbox_header('概览'); ?>
        <table class="form-table">
            <tr>
                <th colspan="2">
                    <label>
                        <input id="enabled" type="checkbox" name="enabled" value="1"<?php checked($enabled_checkbox, true); ?> />
                   切换所有缓存类型或立刻关闭。
                    </label>
                </th>
            </tr>
            <tr>
                <th>预览模式:</th>
                <td>
                    <?php echo $this->nonce_field('w3tc'); ?>
                    <?php if ($preview): ?>
                    <input type="hidden" name="preview" value="0" />
                    <input type="submit" name="w3tc_preview_save" class="button-primary" value="关闭" />
                    <?php echo $this->button_link('Preview', w3_get_home_url() . '/?w3tc_preview=1', true); ?>
                    <?php echo $this->button_link('Deploy', sprintf('admin.php?page=%s&w3tc_preview_deploy', $this->_page)); ?>
                    <?php else: ?>
                    <input type="hidden" name="preview" value="1" />
                    <input type="submit" name="w3tc_preview_save" class="button-primary" value="启用" />
                    <?php endif; ?>
                    <br /><span class="description">使用预览模式来测试配置方案在实际的网站上部署的效果。</span>
                </td>
            </tr>
        </table>

        <p class="submit">
            <?php echo $this->nonce_field('w3tc'); ?>
            <input type="submit" name="w3tc_save_options" class="w3tc-button-save button-primary" value="保存设置" />
        </p>
        <?php echo $this->postbox_footer(); ?>

        <?php echo $this->postbox_header('页面缓存'); ?>
        <p>启用页面缓存，以减少您的网站的响应时间。</p>

        <table class="form-table">
            <tr>
                <th>页面缓存：</th>
                <td>
                    <input type="hidden" name="pgcache.enabled" value="0" />
                    <label><input class="enabled" type="checkbox" name="pgcache.enabled" value="1"<?php checked($pgcache_enabled, true); ?> />&nbsp;<strong>启用</strong></label>
                    <br /><span class="description">缓存网页会降低你的网站的响应时间和提高您的Web服务器的效率。</span>
                </td>
            </tr>
            <tr>
                <th>页面缓存模式:</th>
                <td>
                    <select name="pgcache.engine">
                        <optgroup label="Shared Server (磁盘：增强模式最佳):">
                            <option value="file"<?php selected($this->_config->get_string('pgcache.engine'), 'file'); ?>>磁盘：基础模式</option>
                            <option value="file_generic"<?php selected($this->_config->get_string('pgcache.engine'), 'file_generic'); ?><?php if (! $check_rules): ?> disabled="disabled"<?php endif; ?>>磁盘：增强模式</option>
                        </optgroup>
                        <optgroup label="Dedicated / Virtual Server:">
                            <option value="apc"<?php selected($this->_config->get_string('pgcache.engine'), 'apc'); ?><?php if (! $check_apc): ?> disabled="disabled"<?php endif; ?>>Opcode: Alternative PHP Cache (APC)</option>
                            <option value="eaccelerator"<?php selected($this->_config->get_string('pgcache.engine'), 'eaccelerator'); ?><?php if (! $check_eaccelerator): ?> disabled="disabled"<?php endif; ?>>Opcode: eAccelerator</option>
                            <option value="xcache"<?php selected($this->_config->get_string('pgcache.engine'), 'xcache'); ?><?php if (! $check_xcache): ?> disabled="disabled"<?php endif; ?>>Opcode: XCache</option>
                        <option value="wincache"<?php selected($this->_config->get_string('pgcache.engine'), 'wincache'); ?><?php if (! $check_wincache): ?> disabled="disabled"<?php endif; ?>>Opcode: WinCache</option>
                        </optgroup>
                        <optgroup label="Multiple Servers:">
                            <option value="memcached"<?php selected($this->_config->get_string('pgcache.engine'), 'memcached'); ?><?php if (! $check_memcached): ?> disabled="disabled"<?php endif; ?>>Memcached分布式缓存*</option>
                        </optgroup>
                    </select>
                </td>
            </tr>
        </table>

        <p class="submit">
            <?php echo $this->nonce_field('w3tc'); ?>
            <input type="submit" name="w3tc_save_options" class="w3tc-button-save button-primary" value="保存设置" />
            <input type="submit" name="w3tc_flush_pgcache" value="清空缓存"<?php if (! $pgcache_enabled): ?> disabled="disabled"<?php endif; ?> class="button" />
        </p>
        <?php echo $this->postbox_footer(); ?>

        <?php echo $this->postbox_header('Minify压缩'); ?>
        <p>减少CSS和JS文件的大小和数量，减少加载时间。自动删除来自CSS，JS，feed和页面HTML的不必要的数据（如空行、注释）</p>

        <table class="form-table">
            <tr>
                <th>Minify压缩:</th>
                <td>
                    <input type="hidden" name="minify.enabled" value="0"<?php if (! W3TC_PHP5): ?> disabled="disabled"<?php endif; ?> />
                    <label><input class="enabled" type="checkbox" name="minify.enabled" value="1"<?php checked($minify_enabled, true); ?><?php if (! W3TC_PHP5): ?> disabled="disabled"<?php endif; ?> />&nbsp;<strong>启用</strong></label>
                    <br /><span class="description">Minfy压缩分别对 <acronym title="Hypertext Markup Language">HTML</acronym>, <acronym title="Cascading Style Sheet">CSS</acronym>, <acronym title="JavaScript">JS</acronym> 和 feeds等文件的体积减少大概 10% 。</span>
                </td>
            </tr>
            <tr>
                <th>Minify压缩模式：</th>
                <td>
                    <label><input type="radio" name="minify.auto" value="1"<?php checked($this->_config->get_boolean('minify.auto'), true); ?><?php if (! W3TC_PHP5): ?> disabled="disabled"<?php endif; ?> /> 自动</label>
                    <label><input type="radio" name="minify.auto" value="0"<?php checked($this->_config->get_boolean('minify.auto'), false); ?><?php if (! W3TC_PHP5): ?> disabled="disabled"<?php endif; ?> /> 手动</label>
					<br /><span class="description">选择手动模式必须在“Minify压缩”选项卡设置选择指定文件来压缩，注意在手动模式下不可以使用“ <acronym title="Content Delivery Network">CDN</acronym>”选项卡。</span>
                </td>
            </tr>
            <tr>
                <th>Minify缓存模式：</th>
                <td>
                    <select name="minify.engine"<?php if (! W3TC_PHP5): ?> disabled="disabled"<?php endif; ?>>
                        <optgroup label="Shared Server (磁盘模式最佳):">
                            <option value="file"<?php selected($this->_config->get_string('minify.engine'), 'file'); ?>>磁盘模式</option>
                        </optgroup>
                        <optgroup label="Dedicated / Virtual Server:">
                            <option value="apc"<?php selected($this->_config->get_string('minify.engine'), 'apc'); ?><?php if (! $check_apc): ?> disabled="disabled"<?php endif; ?>>Opcode: Alternative PHP Cache (APC)</option>
                            <option value="eaccelerator"<?php selected($this->_config->get_string('minify.engine'), 'eaccelerator'); ?><?php if (! $check_eaccelerator): ?> disabled="disabled"<?php endif; ?>>Opcode: eAccelerator</option>
                            <option value="xcache"<?php selected($this->_config->get_string('minify.engine'), 'xcache'); ?><?php if (! $check_xcache): ?> disabled="disabled"<?php endif; ?>>Opcode: XCache</option>
                            <option value="wincache"<?php selected($this->_config->get_string('minify.engine'), 'wincache'); ?><?php if (! $check_wincache): ?> disabled="disabled"<?php endif; ?>>Opcode: WinCache</option>
                        </optgroup>
                            <optgroup label="Multiple Servers:">
                            <option value="memcached"<?php selected($this->_config->get_string('minify.engine'), 'memcached'); ?><?php if (! $check_memcached): ?> disabled="disabled"<?php endif; ?>>Memcached分布式缓存*</option>
                        </optgroup>
                    </select>
                </td>
            </tr>
            <tr>
                <th><acronym title="Hypertext Markup Language">HTML</acronym>压缩：</th>
                <td>
                    <select name="minify.html.engine"<?php if (! W3TC_PHP5): ?> disabled="disabled"<?php endif; ?>>
                        <option value="html"<?php selected($this->_config->get_string('minify.html.engine'), 'html'); ?>>默认</option>
                        <option value="htmltidy"<?php selected($this->_config->get_string('minify.html.engine'), 'htmltidy'); ?><?php if (! $check_tidy): ?> disabled="disabled"<?php endif; ?>>HTML Tidy（HTML转化）</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><acronym title="JavaScript">JS</acronym> 压缩：</th>
                <td>
                    <select name="minify.js.engine"<?php if (! W3TC_PHP5): ?> disabled="disabled"<?php endif; ?>>
                        <option value="js"<?php selected($this->_config->get_string('minify.js.engine'), 'js'); ?>>JSMin (默认)</option>
                        <option value="yuijs"<?php selected($this->_config->get_string('minify.js.engine'), 'yuijs'); ?>>YUI Compressor</option>
                        <option value="ccjs"<?php selected($this->_config->get_string('minify.js.engine'), 'ccjs'); ?>>Closure Compiler</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><acronym title="Cascading Style Sheets">CSS</acronym> 压缩：</th>
                <td>
                    <select name="minify.css.engine"<?php if (! W3TC_PHP5): ?> disabled="disabled"<?php endif; ?>>
                        <option value="css"<?php selected($this->_config->get_string('minify.css.engine'), 'css'); ?>>默认</option>
                        <option value="yuicss"<?php selected($this->_config->get_string('minify.css.engine'), 'yuicss'); ?>>YUI Compressor</option>
                        <option value="csstidy"<?php selected($this->_config->get_string('minify.css.engine'), 'csstidy'); ?>>CSS Tidy</option>
                    </select>
                </td>
            </tr>
        </table>

        <p class="submit">
            <?php echo $this->nonce_field('w3tc'); ?>
            <input type="submit" name="w3tc_save_options" class="w3tc-button-save button-primary" value="保存设置" />
            <input type="submit" name="w3tc_flush_minify" value="清空缓存"<?php if (! $minify_enabled): ?> disabled="disabled"<?php endif; ?> class="button" />
        </p>
        <?php echo $this->postbox_footer(); ?>

        <?php echo $this->postbox_header('数据库缓存'); ?>
        <p>使用数据库缓存可以减少你的文章、页面的加载时间。</p>

         <table class="form-table">
            <tr>
                <th>数据库缓存：</th>
                <td>
                    <input type="hidden" name="dbcache.enabled" value="0" />
                    <label><input class="enabled" type="checkbox" name="dbcache.enabled" value="1"<?php checked($dbcache_enabled, true); ?> />&nbsp;<strong>启用</strong></label>
                    <br /><span class="description">数据库缓存可以减少你的网站应答时间，使用数据库缓存最好不要使用对象缓存。</span>
                </td>
            </tr>
            <tr>
                <th>数据库缓存模式：</th>
                <td>
                    <select name="dbcache.engine">
                        <optgroup label="Shared Server:">
                            <option value="file"<?php selected($this->_config->get_string('dbcache.engine'), 'file'); ?>>磁盘模式</option>
                        </optgroup>
                        <optgroup label="Dedicated / Virtual Server:">
                            <option value="apc"<?php selected($this->_config->get_string('dbcache.engine'), 'apc'); ?><?php if (! $check_apc): ?> disabled="disabled"<?php endif; ?>>Opcode: Alternative PHP Cache (APC)</option>
                            <option value="eaccelerator"<?php selected($this->_config->get_string('dbcache.engine'), 'eaccelerator'); ?><?php if (! $check_eaccelerator): ?> disabled="disabled"<?php endif; ?>>Opcode: eAccelerator</option>
                            <option value="xcache"<?php selected($this->_config->get_string('dbcache.engine'), 'xcache'); ?><?php if (! $check_xcache): ?> disabled="disabled"<?php endif; ?>>Opcode: XCache</option>
                            <option value="wincache"<?php selected($this->_config->get_string('dbcache.engine'), 'wincache'); ?><?php if (! $check_wincache): ?> disabled="disabled"<?php endif; ?>>Opcode: WinCache</option>
                    </optgroup>
                        <optgroup label="Multiple Servers:">
                            <option value="memcached"<?php selected($this->_config->get_string('dbcache.engine'), 'memcached'); ?><?php if (! $check_memcached): ?> disabled="disabled"<?php endif; ?>>Memcached</option>
                        </optgroup>
                    </select>
                </td>
            </tr>
        </table>

        <p class="submit">
            <?php echo $this->nonce_field('w3tc'); ?>
            <input type="submit" name="w3tc_save_options" class="w3tc-button-save button-primary" value="保存设置" />
            <input type="submit" name="w3tc_flush_dbcache" value="清空缓存"<?php if (! $dbcache_enabled): ?> disabled="disabled"<?php endif; ?> class="button" />
        </p>
        <?php echo $this->postbox_footer(); ?>

        <?php echo $this->postbox_header('Object Cache'); ?>
        <p>启用对象缓存以进一步降低操作的执行时间。</p>

        <table class="form-table">
            <tr>
                <th>对象缓存：</th>
                <td>
                    <input type="hidden" name="objectcache.enabled" value="0" />
                    <label><input class="enabled" type="checkbox" name="objectcache.enabled" value="1"<?php checked($objectcache_enabled, true); ?> />&nbsp;<strong>启用</strong></label>
                    <br /><span class="description">对象缓存能大大增加了高度动态的网站的缓存功能（即使用对象缓存的性能）。</span>
                </td>
            </tr>
            <tr>
                <th>对象缓存模式：</th>
                <td>
                    <select name="objectcache.engine">
                        <optgroup label="Shared Server:">
                            <option value="file"<?php selected($this->_config->get_string('objectcache.engine'), 'file'); ?>>磁盘模式</option>
                        </optgroup>
                        <optgroup label="Dedicated / Virtual Server:">
                            <option value="apc"<?php selected($this->_config->get_string('objectcache.engine'), 'apc'); ?><?php if (! $check_apc): ?> disabled="disabled"<?php endif; ?>>Opcode: Alternative PHP Cache (APC)</option>
                            <option value="eaccelerator"<?php selected($this->_config->get_string('objectcache.engine'), 'eaccelerator'); ?><?php if (! $check_eaccelerator): ?> disabled="disabled"<?php endif; ?>>Opcode: eAccelerator</option>
                            <option value="xcache"<?php selected($this->_config->get_string('objectcache.engine'), 'xcache'); ?><?php if (! $check_xcache): ?> disabled="disabled"<?php endif; ?>>Opcode: XCache</option>
                            <option value="wincache"<?php selected($this->_config->get_string('objectcache.engine'), 'wincache'); ?><?php if (! $check_wincache): ?> disabled="disabled"<?php endif; ?>>Opcode: WinCache</option>
                    </optgroup>
                        <optgroup label="Multiple Servers:">
                            <option value="memcached"<?php selected($this->_config->get_string('objectcache.engine'), 'memcached'); ?><?php if (! $check_memcached): ?> disabled="disabled"<?php endif; ?>>Memcached</option>
                        </optgroup>
                    </select>
                </td>
            </tr>
        </table>

        <p class="submit">
            <?php echo $this->nonce_field('w3tc'); ?>
            <input type="submit" name="w3tc_save_options" class="w3tc-button-save button-primary" value="保存设置" />
            <input type="submit" name="w3tc_flush_objectcache" value="清空缓存"<?php if (! $objectcache_enabled): ?> disabled="disabled"<?php endif; ?> class="button" />
        </p>
        <?php echo $this->postbox_footer(); ?>

        <?php echo $this->postbox_header('Browser Cache'); ?>
        <p>降低服务器的负载，并通过网站访客的网页浏览器中的缓存来减少响应时间。</p>

        <table class="form-table">
            <tr>
                <th>浏览器缓存：</th>
                <td>
                    <input type="hidden" name="browsercache.enabled" value="0" />
                    <label><input class="enabled" type="checkbox" name="browsercache.enabled" value="1"<?php checked($browsercache_enabled, true); ?> />&nbsp;<strong>启用</strong></label>
                    <br /><span class="description">启用<acronym title="Hypertext Transfer Protocol">HTTP</acronym>压缩以减少服务器的负载，减少文件加载时间。</span>
                </td>
            </tr>
        </table>

        <p class="submit">
            <?php echo $this->nonce_field('w3tc'); ?>
            <input type="submit" name="w3tc_save_options" class="w3tc-button-save button-primary" value="保存设置" />
        </p>
        <?php echo $this->postbox_footer(); ?>

        <?php echo $this->postbox_header('<acronym title="Content Delivery Network">CDN</acronym>'); ?>
        <p>压缩主机与CDN加速提供商的静态文件，以减少网页加载时间。</p>

        <table class="form-table">
            <tr>
                <th><acronym title="Content Delivery Network">CDN</acronym>:</th>
                <td>
                    <input type="hidden" name="cdn.enabled" value="0" />
                    <label><input class="enabled" type="checkbox" name="cdn.enabled" value="1"<?php checked($cdn_enabled, true); ?> />&nbsp;<strong>启用</strong></label>
                    <br /><span class="description">网站有访问请求时，主题文件，媒体库附件，CSS，JS等文件会即刻加载。</span>
                </td>
            </tr>
            <tr>
                <th><acronym title="Content Delivery Network">CDN</acronym> 服务商：</th>
                <td>
                    <select name="cdn.engine">
                        <optgroup label="Origin Pull (mirror is best):">
                            <option value="cf2"<?php selected($this->_config->get_string('cdn.engine'), 'cf2'); ?><?php if (!W3TC_PHP5 || !$check_curl): ?> disabled="disabled"<?php endif; ?>>Amazon CloudFront</option>
                            <option value="cotendo"<?php selected($this->_config->get_string('cdn.engine'), 'cotendo'); ?>>Cotendo</option>
                            <option value="mirror"<?php selected($this->_config->get_string('cdn.engine'), 'mirror'); ?>>Generic Mirror</option>
                            <option value="edgecast"<?php selected($this->_config->get_string('cdn.engine'), 'edgecast'); ?>>Media Temple ProCDN / EdgeCast</option>
                            <option value="netdna"<?php selected($this->_config->get_string('cdn.engine'), 'netdna'); ?>>NetDNA / MaxCDN</option>
                        </optgroup>
                        <optgroup label="Origin Push:">
                            <option value="cf"<?php selected($this->_config->get_string('cdn.engine'), 'cf'); ?><?php if (!W3TC_PHP5 || !$check_curl): ?> disabled="disabled"<?php endif; ?>>Amazon CloudFront</option>
                            <option value="s3"<?php selected($this->_config->get_string('cdn.engine'), 's3'); ?><?php if (!W3TC_PHP5 || !$check_curl): ?> disabled="disabled"<?php endif; ?>>Amazon Simple Storage Service (S3)</option>
                            <option value="azure"<?php selected($this->_config->get_string('cdn.engine'), 'azure'); ?><?php if (!W3TC_PHP5): ?> disabled="disabled"<?php endif; ?>>Microsoft Azure Storage</option>
                            <option value="rscf"<?php selected($this->_config->get_string('cdn.engine'), 'rscf'); ?><?php if (!W3TC_PHP5 || !$check_curl): ?> disabled="disabled"<?php endif; ?>>Rackspace Cloud Files</option>
                            <option value="ftp"<?php selected($this->_config->get_string('cdn.engine'), 'ftp'); ?><?php if (!$check_ftp): ?> disabled="disabled"<?php endif; ?>>Self-hosted / File Transfer Protocol Upload</option>
                        </optgroup>
                    </select><br />
                    <span class="description">选择你要使用的CDN加速服务商。</span>
                </td>
            </tr>
        </table>

        <p class="submit">
            <?php echo $this->nonce_field('w3tc'); ?>
            <input type="submit" name="w3tc_save_options" class="w3tc-button-save button-primary" value="保存设置" />
            <input id="cdn_purge" type="button" value="清除缓存"<?php if (!$cdn_enabled || !w3_can_cdn_purge($this->_config->get_string('cdn.engine'))): ?> disabled="disabled"<?php endif; ?> class="button" />
        </p>
        <?php echo $this->postbox_footer(); ?>

        <?php echo $this->postbox_header('Varnish'); ?>
        <table class="form-table">
            <tr>
                <th colspan="2">
                    <input type="hidden" name="varnish.enabled" value="0" />
                    <label><input class="enabled" type="checkbox" name="varnish.enabled" value="1"<?php checked($varnish_enabled, true); ?> /> Enable varnish cache purging</label><br />
                </th>
            </tr>
             <tr>
                 <th><label for="pgcache_varnish_servers">Varnish servers:</label></th>
                 <td>
                    <textarea id="pgcache_varnish_servers" name="varnish.servers" cols="40" rows="5"><?php echo htmlspecialchars(implode("\r\n", $this->_config->get_array('varnish.servers'))); ?></textarea><br />
                    <span class="description">Specify the IP addresses of your varnish instances above. Your <acronym title="Varnish Configuration Language">VCL</acronym>'s <acronym title="Access Control List">ACL</acronym> must allow this request.</span>
                </td>
            </tr>
        </table>

        <p class="submit">
            <?php echo $this->nonce_field('w3tc'); ?>
            <input type="submit" name="w3tc_save_options" class="w3tc-button-save button-primary" value="保存设置" />
        </p>
        <?php echo $this->postbox_footer(); ?>

        <?php echo $this->postbox_header('网络性能，由CloudFlare提供安全保护'); ?>
        <p>
           CloudFlare保护和加速网站，<a href="https://www.cloudflare.com/sign-up.html?affiliate=w3edge&amp;seed_domain=<?php echo w3_get_host(); ?>&amp;email=<?php echo htmlspecialchars($cloudflare_signup_email); ?>&amp;username=<?php echo htmlspecialchars($cloudflare_signup_user); ?>" target="_blank">免费注册</a> 即可获得，
            如果你有一个帐户，只需<a href="https://www.cloudflare.com/my-account.html">登陆</a>到从帐户页面获取在下面输入您的API密钥。有任何疑问，请联系<a href="http://www.cloudflare.com/help.html" target="_blank">CloudFlare支持团队</a> 。
        </p>

        <table class="form-table">
            <tr>
                <th>CloudFlare:</th>
                <td>
                    <input type="hidden" name="cloudflare.enabled" value="0" />
                    <label><input class="enabled" type="checkbox" name="cloudflare.enabled" value="1"<?php checked($cloudflare_enabled, true); ?> />&nbsp;<strong>启用</strong></label>
                </td>
            </tr>
            <tr>
                <th><label for="cloudflare_email">CloudFlare 账号（电子邮箱）：</label></th>
                <td>
                    <input id="cloudflare_email" class="w3tc-ignore-change" type="text" name="cloudflare.email" value="<?php echo htmlspecialchars($this->_config->get_string('cloudflare.email')); ?>" size="60" />
                </td>
            </tr>
            <tr>
                <th><label for="cloudflare_key"><acronym title="Application Programming Interface">API</acronym> key:</label></th>
                <td>
                    <input id="cloudflare_key" class="w3tc-ignore-change" type="password" name="cloudflare.key" value="<?php echo htmlspecialchars($this->_config->get_string('cloudflare.key')); ?>" size="60" /> (<a href="https://www.cloudflare.com/my-account.html">点击寻找你的API key</a>)
                </td>
            </tr>
            <tr>
                <th>域名：</th>
                <td>
                    <input id="cloudflare_zone" type="text" name="cloudflare.zone" value="<?php echo htmlspecialchars($this->_config->get_string('cloudflare.zone', w3_get_host())); ?>" size="40" />
                </td>
            </tr>
            <tr>
                <th>安全等级：</th>
                <td>
                    <input type="hidden" name="cloudflare_seclvl_old" value="<?php echo $cloudflare_seclvl; ?>" />
                    <select name="cloudflare_seclvl_new" class="w3tc-ignore-change">
                        <?php foreach ($cloudflare_seclvls as $cloudflare_seclvl_key => $cloudflare_seclvl_label): ?>
                        <option value="<?php echo $cloudflare_seclvl_key; ?>"<?php selected($cloudflare_seclvl, $cloudflare_seclvl_key); ?>><?php echo $cloudflare_seclvl_label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>高级模式：</th>
                <td>
                    <input type="hidden" name="cloudflare_devmode_old" value="<?php echo $cloudflare_devmode; ?>" />
                    <select name="cloudflare_devmode_new" class="w3tc-ignore-change">
                        <?php foreach ($cloudflare_devmodes as $cloudflare_devmode_key => $cloudflare_devmode_label): ?>
                        <option value="<?php echo $cloudflare_devmode_key; ?>"<?php selected($cloudflare_devmode, $cloudflare_devmode_key); ?>><?php echo $cloudflare_devmode_label; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($cloudflare_devmode_expire): ?>
                    将在 <?php echo date('m/d/Y H:i:s', $cloudflare_devmode_expire); ?>自动关闭
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <p class="submit">
            <?php echo $this->nonce_field('w3tc'); ?>
            <input type="submit" name="w3tc_save_options" class="w3tc-button-save button-primary" value="保存设置" />
            <input id="cloudflare_purge_cache" class="button {nonce: '<?php echo wp_create_nonce('w3tc'); ?>'}" type="button" value="清除缓存"<?php if (! $cloudflare_enabled): ?> disabled="disabled"<?php endif; ?> />
        </p>
        <?php echo $this->postbox_footer(); ?>

        <?php echo $this->postbox_header('支持我们'); ?>
        <p>我们为wordpress做的更好，点击支持我们</p>

        <p>
            <label>在你的
                <select name="common.support">
                    <option value="">选择一个</option>
                    <?php foreach ($supports as $support_id => $support_name): ?>
                    <option value="<?php echo $support_id; ?>"<?php selected($support, $support_id); ?>><?php echo htmlspecialchars($support_name); ?></option>
                    <?php endforeach; ?>
                </select>联系我们，
            </label>, 告诉你的朋友在<input type="button" class="button button-tweet" value="推特" />
            (<input type="hidden" name="common.tweeted" value="0" /><label><input type="checkbox" name="common.tweeted" value="1"<?php checked($this->_config->get_boolean('common.tweeted', true)); ?> /> 我已经发推特消息了</label>)
            或者给我们 <input type="button" class="button button-rating" value="联系" />.
        </p>

        <p>如果你想手动放置一个链接，这里是代码：</p>
        <p><textarea cols="80" rows="4">Performance Optimization &lt;a href=&quot;http://www.w3-edge.com/wordpress-plugins/&quot; rel=&quot;external&quot;&gt;WordPress Plugins&lt;/a&gt; by W3 EDGE</textarea></p>

        <p class="submit">
            <?php echo $this->nonce_field('w3tc'); ?>
            <input type="submit" name="w3tc_save_options" class="w3tc-button-save button-primary" value="保存设置" />
        </p>
        <?php echo $this->postbox_footer(); ?>
        <?php echo $this->postbox_header('杂项'); ?>
        <table class="form-table">
            <?php if (w3_is_nginx()): ?>
            <tr>
                <th>Nginx server configuration file path</th>
                <td>
                    <input type="text" name="config.path" value="<?php echo htmlspecialchars($this->_config->get_string('config.path')); ?>" size="80" />
                    <br /><span class="description">If empty the default path will be used..</span>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <th colspan="2">
                    <input type="hidden" name="config.check" value="0" />
                    <label><input type="checkbox" name="config.check" value="1"<?php checked($this->_config->get_boolean('config.check'), true); ?> /> 验证重写规则</label>
                    <br /><span class="description">通知服务器配置错误，如果这个选项被禁用，主动设置服务器配置可以在 <a href="admin.php?page=w3tc_install">安装</a> 选项卡上找到。</span>
                </th>
            </tr>
            <tr>
                <th colspan="2">
                    <input type="hidden" name="file_locking" value="0"<?php if (! $can_empty_file): ?> disabled="disabled"<?php endif; ?> />
                    <label><input type="checkbox" name="file_locking" value="1"<?php checked($file_locking, true); ?><?php if (! $can_empty_file): ?> disabled="disabled"<?php endif; ?> />  启用文件锁定</label>
                    <br /><span class="description">不推荐在“慢”的网络的文件系统使用。</span>
                </th>
            </tr>
            <tr>
                <th colspan="2">
                    <input type="hidden" name="file_nfs" value="0"<?php if (! $can_empty_file): ?> disabled="disabled"<?php endif; ?> />
                    <label><input type="checkbox" name="file_nfs" value="1"<?php checked($file_nfs, true); ?><?php if (! $can_empty_file): ?> disabled="disabled"<?php endif; ?> /> 优化磁盘增强页面为<acronym title="Network File System">NFS</acronym>缓存 。</label>
                    <br /><span class="description">如果您的托管环境中使用基于网络的文件系统性能改进了，试试这个选项。</span>
                </th>
            </tr>
            <tr>
                <th colspan="2">
                    <input type="hidden" name="widget.latest.enabled" value="0" />
                    <label><input type="checkbox" name="widget.latest.enabled" value="1"<?php checked($this->_config->get_boolean('widget.latest.enabled'), true); ?> />在仪表盘启用消息提示小工具 </label>
                    <br /><span class="description">显示最新的推特消息和支持WordPress的仪表盘提示。</span>
                </th>
            </tr>
            <tr>
                <th colspan="2">
                    <input type="hidden" name="widget.pagespeed.enabled" value="0" />
                    <label><input type="checkbox" name="widget.pagespeed.enabled" value="1"<?php checked($this->_config->get_boolean('widget.pagespeed.enabled'), true); ?> />  启用谷歌Page Speed 小工具</label>
                    <br /><span class="description">在WordPress仪表盘显示来自谷歌Page Speed的速度数据。</span>
                </th>
            </tr>
            <tr>
                <th><label for="widget_pagespeed_key">Page Speed <acronym title="Application Programming Interface">API</acronym> Key:</label></th>
                <td>
                    <input id="widget_pagespeed_key" type="text" name="widget.pagespeed.key" value="<?php echo $this->_config->get_string('widget.pagespeed.key'); ?>" size="60" /><br />
                    <span class="description">要获得 <acronym title="Application Programming Interface">API</acronym> key, 访问 <a href="https://code.google.com/apis/console" target="_blank"><acronym title="Application Programming Interface">API</acronym>控制台</a>，在线激活<acronym title="Application Programming Interface">API</acronym>接受服务。
                      APIkey是在API访问的地方。</span>
                </td>
            </tr>
        </table>

        <p class="submit">
            <?php echo $this->nonce_field('w3tc'); ?>
            <input type="submit" name="w3tc_save_options" class="w3tc-button-save button-primary" value="保存设置" />
        </p>
        <?php echo $this->postbox_footer(); ?>

        <?php echo $this->postbox_header('调试'); ?>
        <p>每个高速缓存的详细信息将被附加在页面的源代码，HTML注释（公开）。在这种模式下的性能将不会是最佳的，有节制地使用，并在不使用时禁用。</p>

        <table class="form-table">
            <tr>
                <th>调试模式：</th>
                <td>
                    <input type="hidden" name="pgcache.debug" value="<?php echo ((!$this->_config->get_boolean('pgcache.enabled') && $this->_config->get_boolean('pgcache.debug')) ? "1" : "0") ?>" />
                    <input type="hidden" name="minify.debug" value="<?php echo ((!$this->_config->get_boolean('minify.enabled') && $this->_config->get_boolean('minify.debug')) ? "1" : "0") ?>" />
                    <input type="hidden" name="dbcache.debug" value="<?php echo ((!$this->_config->get_boolean('dbcache.enabled') && $this->_config->get_boolean('dbcache.debug')) ? "1" : "0") ?>" />
                    <input type="hidden" name="objectcache.debug" value="<?php echo ((!$this->_config->get_boolean('objectcache.enabled') && $this->_config->get_boolean('objectcache.debug')) ? "1" : "0") ?>" />
                    <input type="hidden" name="cdn.debug" value="<?php echo ((!$this->_config->get_boolean('cdn.enabled') && $this->_config->get_boolean('cdn.debug')) ? "1" : "0") ?>" />
                    <input type="hidden" name="varnish.debug" value="<?php echo ((!$this->_config->get_boolean('varnish.enabled') && $this->_config->get_boolean('varnish.debug')) ? "1" : "0") ?>" />
                    <label><input type="checkbox" name="pgcache.debug" value="pgcache"<?php checked($this->_config->get_boolean('pgcache.debug') && $this->_config->get_boolean('pgcache.enabled'), true); ?> <?php if (!$this->_config->get_boolean('pgcache.enabled')): ?> disabled="disabled"<?php endif; ?>/> 页面缓存</label><br />
                    <label><input type="checkbox" name="minify.debug" value="minify"<?php checked($this->_config->get_boolean('minify.debug') && $this->_config->get_boolean('minify.enabled'), true); ?> <?php if (!$this->_config->get_boolean('minify.enabled')): ?> disabled="disabled"<?php endif; ?>/> Minify压缩</label><br />
                    <label><input type="checkbox" name="dbcache.debug" value="dbcache"<?php checked($this->_config->get_boolean('dbcache.debug') && $this->_config->get_boolean('dbcache.enabled'), true); ?> <?php if (!$this->_config->get_boolean('dbcache.enabled')): ?> disabled="disabled"<?php endif; ?>/> 数据库缓存</label><br />
                    <label><input type="checkbox" name="objectcache.debug" value="objectcache"<?php checked($this->_config->get_boolean('objectcache.debug') && $this->_config->get_boolean('objectcache.enabled'), true); ?> <?php if (!$this->_config->get_boolean('objectcache.enabled')): ?> disabled="disabled"<?php endif; ?>/> 对象缓存/label><br />
                    <label><input type="checkbox" name="cdn.debug" value="cdn"<?php checked($this->_config->get_boolean('cdn.debug') && $this->_config->get_boolean('cdn.enabled'), true); ?> <?php if (!$this->_config->get_boolean('cdn.enabled')): ?> disabled="disabled"<?php endif; ?>/> Content Delivery Network（CDN）</label><br />
                    <label><input type="checkbox" name="varnish.debug" value="varnish"<?php checked($this->_config->get_boolean('varnish.debug') && $this->_config->get_boolean('varnish.enabled'), true); ?> <?php if (!$this->_config->get_boolean('varnish.enabled')): ?> disabled="disabled"<?php endif; ?>/> Varnish</label><br />
                    <span class="description">如果选中，详细的缓存信息将出现在每一页的末尾，在HTML注释。查看页面的源代码可以审查。</span>
                </td>
            </tr>
        </table>

        <p class="submit">
            <?php echo $this->nonce_field('w3tc'); ?>
            <input type="submit" name="w3tc_save_options" class="w3tc-button-save button-primary" value="保存设置" />
        </p>
        <?php echo $this->postbox_footer(); ?>
    </div>
</form>

<form action="admin.php?page=<?php echo $this->_page; ?>" method="post" enctype="multipart/form-data">
    <div class="metabox-holder">
        <?php echo $this->postbox_header('导入/导出设置'); ?>
        <?php echo $this->nonce_field('w3tc'); ?>
        <table class="form-table">
            <tr>
                <th>导入设置：</th>
                <td>
                    <input type="file" name="config_file" />
                    <input type="submit" name="w3tc_config_import" class="button" value="上传" />
                    <br /><span class="description">上传并取代现用的设置文件。</span>
                </td>
            </tr>
            <tr>
                <th>导出设置：</th>
                <td>
                    <input type="submit" name="w3tc_config_export" class="button" value="下载" />
                    <br /><span class="description">下载设置文件。</span>
                </td>
            </tr>
            <tr>
                <th>重置设置：</th>
                <td>
                    <input type="submit" name="w3tc_config_reset" class="button" value="还原默认设置" />
                    <br /><span class="description">恢复所有设置为默认值。在预览模式下的任何设置将不会被修改。</span>
                </td>
            </tr>
        </table>
        <?php echo $this->postbox_footer(); ?>
    </div>
</form>

<?php include W3TC_INC_DIR . '/options/common/footer.php'; ?>