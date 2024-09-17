<?php
/**
 * Math rendering functions.
 *
 * @package MathJaxLatex
 */

/**
 * The contents of this file are subject to the LGPL License, Version 3.0.
 *
 * Copyright (C) 2010-2013, Phillip Lord, Newcastle University
 * Copyright (C) 2010-2011, Simon Cockell, Newcastle University
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License
 * for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see http://www.gnu.org/licenses/.
 */

/**
 * Math rendering class.
 */
class MathJax_Latex {

	/**
	 * Add the MathJax script to the page.
	 *
	 * @var boolean
	 */
	public static $add_script;

	/**
	 * Block the MathJax script on the page.
	 *
	 * @var boolean
	 */
	public static $block_script;

	/**
	 * Allow MathML tags (for use with KSES).
	 *
	 * @var boolean
	 */
	public static $mathml_tags = [
		'math'           => [ 'class', 'id', 'style', 'dir', 'href', 'mathbackground', 'mathcolor', 'display', 'overflow', 'xmlns' ],
		'maction'        => [ 'actiontype', 'class', 'id', 'style', 'href', 'mathbackground', 'mathcolor', 'selection' ],
		'maligngroup'    => [],
		'malignmark'     => [],
		'menclose'       => [ 'class', 'id', 'style', 'href', 'mathbackground', 'mathcolor', 'notation' ],
		'merror'         => [ 'class', 'id', 'style', 'href', 'mathbackground', 'mathcolor' ],
		'mfenced'        => [ 'class', 'id', 'style', 'close', 'href', 'mathbackground', 'mathcolor', 'open', 'separators' ],
		'mfrac'          => [ 'bevelled', 'class', 'id', 'style', 'denomalign', 'href', 'linethickness', 'mathbackground', 'mathcolor', 'numalign' ],
		'mglyph'         => [ 'alt', 'class', 'id', 'style', 'height', 'href', 'mathbackground', 'src', 'valign', 'width' ],
		'mi'             => [ 'class', 'id', 'style', 'href', 'mathbackground', 'mathcolor', 'mathsize', 'mathvariant' ],
		'mlabeledtr'     => [ 'class', 'id', 'style', 'columnalign', 'groupalign', 'href', 'mathbackground', 'mathcolor', 'rowalign' ],
		'mlongdiv'       => [],
		'mmultiscripts'  => [ 'class', 'id', 'style', 'href', 'mathbackground', 'mathcolor', 'subscriptshift', 'superscriptshift' ],
		'mn'             => [ 'class', 'id', 'style', 'dir', 'href', 'mathbackground', 'mathcolor', 'mathsize', 'mathvariant' ],
		'mo'             => [ 'accent', 'class', 'id', 'style', 'dir', 'fence', 'form', 'href', 'largeop', 'lspace', 'mathbackground', 'mathcolor', 'mathsize', 'mathvariant', 'maxsize', 'minsize', 'moveablelimits', 'rspace', 'separator', 'stretchy', 'symmetric' ],
		'mover'          => [ 'accent', 'align', 'class', 'id', 'style', 'href', 'mathbackground', 'mathcolor' ],
		'mpadded'        => [ 'class', 'id', 'style', 'depth', 'height', 'href', 'lspace', 'mathbackground', 'mathcolor', 'voffset', 'width' ],
		'mphantom'       => [ 'class', 'id', 'style', 'mathbackground' ],
		'mroot'          => [ 'class', 'id', 'style', 'href', 'mathbackground', 'mathcolor' ],
		'mrow'           => [ 'class', 'id', 'style', 'dir', 'href', 'mathbackground', 'mathcolor' ],
		'ms'             => [ 'class', 'id', 'style', 'dir', 'lquote', 'href', 'mathbackground', 'mathcolor', 'mathsize', 'mathvariant', 'rquote' ],
		'mscarries'      => [],
		'mscarry'        => [],
		'msgroup'        => [],
		'msline'         => [],
		'mspace'         => [ 'class', 'id', 'style', 'depth', 'height', 'linebreak', 'mathbackground', 'width' ],
		'msqrt'          => [ 'class', 'id', 'style', 'href', 'mathbackground', 'mathcolor' ],
		'msrow'          => [],
		'mstack'         => [],
		'mstyle'         => [ 'dir', 'decimalpoint', 'displaystyle', 'infixlinebreakstyle', 'scriptlevel', 'scriptminsize', 'scriptsizemultiplier' ],
		'msub'           => [ 'class', 'id', 'style', 'mathbackground', 'mathcolor', 'subscriptshift' ],
		'msubsup'        => [ 'class', 'id', 'style', 'href', 'mathbackground', 'mathcolor', 'subscriptshift', 'superscriptshift' ],
		'msup'           => [ 'class', 'id', 'style', 'href', 'mathbackground', 'mathcolor', 'superscriptshift' ],
		'mtable'         => [ 'class', 'id', 'style', 'align', 'alignmentscope', 'columnalign', 'columnlines', 'columnspacing', 'columnwidth', 'displaystyle', 'equalcolumns', 'equalrows', 'frame', 'framespacing', 'groupalign', 'href', 'mathbackground', 'mathcolor', 'minlabelspacing', 'rowalign', 'rowlines', 'rowspacing', 'side', 'width' ],
		'mtd'            => [ 'class', 'id', 'style', 'columnalign', 'columnspan', 'groupalign', 'href', 'mathbackground', 'mathcolor', 'rowalign', 'rowspan' ],
		'mtext'          => [ 'class', 'id', 'style', 'dir', 'href', 'mathbackground', 'mathcolor', 'mathsize', 'mathvariant' ],
		'mtr'            => [ 'class', 'id', 'style', 'columnalign', 'groupalign', 'href', 'mathbackground', 'mathcolor', 'rowalign' ],
		'munder'         => [ 'accentunder', 'align', 'class', 'id', 'style', 'mathbackground', 'mathcolor' ],
		'munderover'     => [ 'accent', 'accentunder', 'align', 'class', 'id', 'style', 'href', 'mathbackground', 'mathcolor' ],
		'semantics'      => [ 'definitionURL', 'encoding', 'cd', 'name', 'src' ],
		'annotation'     => [ 'definitionURL', 'encoding', 'cd', 'name', 'src' ],
		'annotation-xml' => [ 'definitionURL', 'encoding', 'cd', 'name', 'src' ],
	];

	/**
	 * Register actions and filters.
	 */
	public static function init() {
		register_activation_hook( __FILE__, [ __CLASS__, 'mathjax_install' ] );
		register_deactivation_hook( __FILE__, [ __CLASS__, 'mathjax_uninstall' ] );

		if ( get_option( 'kblog_mathjax_force_load' ) ) {
			self::$add_script = true;
		}

		add_shortcode( 'mathjax', [ __CLASS__, 'mathjax_shortcode' ] );
		add_shortcode( 'nomathjax', [ __CLASS__, 'nomathjax_shortcode' ] );
		add_shortcode( 'latex', [ __CLASS__, 'latex_shortcode' ] );
		add_action( 'wp_footer', [ __CLASS__, 'add_script' ] );
		add_filter( 'script_loader_tag', [ __CLASS__, 'script_loader_tag' ], 10, 3 );

		if ( get_option( 'kblog_mathjax_use_wplatex_syntax' ) ) {
			add_filter( 'the_content', [ __CLASS__, 'inline_to_shortcode' ] );
		}

		add_filter( 'plugin_action_links', [ __CLASS__, 'mathjax_settings_link' ], 9, 2 );

		// add_filter( 'the_content', [ __CLASS__, 'filter_br_tags_on_math' ] );

		// add_filter( 'the_content', array( __CLASS__, 'wp_mathjax_latex_protect_content'), 1 );
		// add_filter( 'the_content', array( __CLASS__, 'wp_mathjax_latex_restore_content'), 100 );

		add_filter('the_content', array( __CLASS__, 'wp_protect_math_content'), 9);
		add_filter('comment_text', array( __CLASS__, 'wp_protect_math_content'), 9);

		add_action( 'init', [ __CLASS__, 'allow_mathml_tags' ] );
		add_filter( 'tiny_mce_before_init', [ __CLASS__, 'allow_mathml_tags_in_tinymce' ] );

		// remove_filter('the_content', 'wpautop');
		// add_filter('the_content', 'wpautop', 12);

		//单个$或者双个$$符号匹配，先匹配 $$ 后匹配 $
		// add_filter("the_content", array(__CLASS__, "katex_markup_single"), 9);
		// add_filter("comment_text", array(__CLASS__, "katex_markup_single"), 9);

		// add_filter("the_content", array(__CLASS__, "katex_markup_double"), 8);
		// add_filter("comment_text", array(__CLASS__, "katex_markup_double"), 8);
	}

	/**
	 * Registers default options.
	 */
	public static function mathjax_install() {
		add_option( 'kblog_mathjax_force_load', false );
		add_option( 'kblog_mathjax_latex_inline', 'inline' );
		add_option( 'kblog_mathjax_use_wplatex_syntax', false );
		add_option( 'kblog_mathjax_use_cdn', true );
		add_option( 'kblog_mathjax_custom_location', false );
		add_option( 'kblog_mathjax_config', 'default' );
	}

	/**
	 * Removes default options.
	 */
	public static function mathjax_uninstall() {
		delete_option( 'kblog_mathjax_force_load' );
		delete_option( 'kblog_mathjax_latex_inline' );
		delete_option( 'kblog_mathjax_use_wplatex_syntax' );
		delete_option( 'kblog_mathjax_use_cdn' );
		delete_option( 'kblog_mathjax_custom_location' );
		delete_option( 'kblog_mathjax_config' );
	}

	/**
	 * Set flag to load [mathjax] shortcode.
	 *
	 * @param array  $atts     Shortcode attributes.
	 * @param string $content  Shortcode content.
	 */
	public static function mathjax_shortcode( $atts, $content ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		self::$add_script = true;
	}

	/**
	 * Set flag to load [nomathjax] shortcode.
	 *
	 * @param array  $atts     Shortcode attributes.
	 * @param string $content  Shortcode content.
	 */
	public static function nomathjax_shortcode( $atts, $content ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		self::$block_script = true;
	}

	/**
	 * Enable [latex] shortcode.
	 *
	 * @param array  $atts     Shortcode attributes.
	 * @param string $content  Shortcode content.
	 */
	public static function latex_shortcode( $atts, $content ) {
		self::$add_script = true;

		// This gives us an optional "syntax" attribute, which defaults to "inline", but can also be "display".
		$shortcode_atts = shortcode_atts(
			[
				'syntax' => get_option( 'kblog_mathjax_latex_inline' ),
			],
			$atts
		);

		if ( 'inline' === $shortcode_atts['syntax'] ) {
			return '\(' . $content . '\)';
		} elseif ( 'display' === $shortcode_atts['syntax'] ) {
			return '\[' . $content . '\]';
		}
	}

	/**
	 * Add script sync in mathjax
	 *
	 */
	public static function add_async_to_mathjax_script( $tag, $handle, $src ) {
		// var_dump($tag, $handle, $src);
		// echo "<br />";
		// echo $src;
		if ( 'mathjax' === $handle ) {
			// $tag = '<script async type="text/javascript" src="' . esc_url( $src ) . '" id="mathjax-js"></script>';
			$tag = str_replace( '<script src="', '<script async src="', $tag );
			return $tag;
		}
		// if ( 'mathjax' === $handle ) {
		// 	echo $tag;
		// 	$tag = '<script async type="text/javascript" src="' . esc_url( $src ) . '" id="mathjax-js"></script>';
		// }

		// echo "right here";

		// Add async attribute
		
		return $tag;
		// return $tag;
	}

	public static function katex_markup_single($content) {
        // 匹配单行LaTeX
        $regexTeXInline = '
        %
        \$
            ((?:
                [^$]+ # Not a dollar
                |
                (?<=(?<!\\\\)\\\\)\$ # Dollar preceded by exactly one slash
                )+)
            (?<!\\\\)
        \$ # Dollar preceded by zero slashes
        %ix';

        // 简易版本，可能存在误判，但尽可能简单，以避免上面这个LaTeX引起的性能问题
        $regexTeXMultilineLite = "/\$[\S\ ]+?\$/ix";
        
        $content = preg_replace_callback($regexTeXMultilineLite, array($this, "katex_src_replace"), $content);

        $textarr = wp_html_split($content);

        // 需要跳过的行数
        $count = 0;
        // 是否需要跳过LaTeX解析
        $pass  = false;
        // 是否在代码块内
        $isInCodeBlock = false;

        foreach ($textarr as &$element) {
            // 默认进行LaTeX解析，如果满足下面的判断条件，则跳过
            $pass = false;

            // 判断已经跳过的行数
            if ($count > 0) {
                ++ $count;
            }

            /**
             * 1. 判断是否满足如下规则，如果是则不进行LaTeX解析
             * <pre>
             * </pre>
             */
            // 判断是否是<pre>然后开始计数，此时为第一行
            if (htmlspecialchars_decode($element) == "<pre>") {
                $isInCodeBlock = true;
                $pass = true;
            }

            // 如果发现是</pre>标签，则表示代码部分结束，继续处理
            if (htmlspecialchars_decode($element) == "</pre>") {
                $isInCodeBlock = false;
                $pass = false;
            }

            /**
             * 2. 对于使用```katex的多行LaTeX，不在里面进行单行LaTeX的重复解析
             */
            if (strpos(htmlspecialchars_decode($element), '<div class="katex math') === 0) {
                $count = 1;
                $pass = true;
            }
            
            if ($count == 3 && htmlspecialchars_decode($element) == "</div>") {
                $count = 0;
                $pass = false;
            }

            /**
             * 3. 对于其他空行或可能为HTML单行标签的行，直接跳过
             */
            if ($element == "" || $element[0] == "<" || stripos($element, "$") === false) {
                $pass = true;
            }

            /**
             * 4. 如果当前还在代码块内，继续跳过
             */
            if ($isInCodeBlock) {
                $pass = true;
            }

            // 如果存在需要跳过LaTeX解析的情况，在这里跳过
            if ($pass) {
                continue;
            } else {
                $element = preg_replace_callback($regexTeXInline, array($this, "katex_src_inline"), $element);
            }
        }

        return implode("", $textarr);
    }

	public static function katex_markup_double($content) {

        // 匹配多行LaTeX
        // 尽管只是多了一个$符号，却会引起指数级的回溯
        $regexTeXMultiline = '
        %
        \$\$
            ((?:
                [^$]+ # Not a dollar
                |
                (?<=(?<!\\\\)\\\\)\$ # Dollar preceded by exactly one slash
                )+)
            (?<!\\\\)
        \$\$ # Dollar preceded by zero slashes
        %ix';

        // 简易版本，可能存在误判，但尽可能简单，以避免上面这个LaTeX引起的性能问题
        $regexTeXMultilineLite = '
        %
		\$\$
			([\S\s]+?)
		\$\$
        %ix';

        $content = preg_replace_callback($regexTeXMultilineLite, array($this, "katex_src_replace"), $content);

        $textarr = wp_html_split($content);

        // 需要跳过的行数
        $count = 0;
        // 是否需要跳过LaTeX解析
        $pass  = false;
        // 是否在代码块内
        $isInCodeBlock = false;

        foreach ($textarr as &$element) {
            // 默认进行LaTeX解析，如果满足下面的判断条件，则跳过
            $pass = false;

            // 判断已经跳过的行数
            if ($count > 0) {
                ++ $count;
            }

            /**
             * 1. 判断是否满足如下规则，如果是则不进行LaTeX解析
             * <pre>
             * </pre>
             */
            // 判断是否是<pre>然后开始计数，此时为第一行
            if (htmlspecialchars_decode($element) == "<pre>") {
                $isInCodeBlock = true;
                $pass = true;
            }

            // 如果发现是</pre>标签，则表示代码部分结束，继续处理
            if (htmlspecialchars_decode($element) == "</pre>") {
                $isInCodeBlock = false;
                $pass = false;
            }

            /**
             * 2. 对于其他空行或可能为HTML单行标签的行，直接跳过
             */
            if ($element == "" || $element[0] == "<" || !stripos($element, "$$")) {
                $pass = true;
            }

            /**
             * 3. 如果当前还在代码块内，继续跳过
             */
            if ($isInCodeBlock) {
                $pass = true;
            }

            // 如果存在需要跳过LaTeX解析的情况，在这里跳过
            if ($pass) {
                continue;
            } else {
                $element = preg_replace_callback($regexTeXMultiline, array(__CLASS__, "katex_src_multiline"), $element);
            }
        }

        return implode("", $textarr);
    }

	public static function katex_src_replace($matches) {

        //在如果公式含有_则会被Markdown解析，所以现在需要转换过来
        $content = str_replace(
            array("<em>", "</em>"),
            array("_", "_"),
            $matches[0]
        );

        return $content;
    }

	/**
	 * Protect LaTeX content by converting it to HTML entities
	 *
	 * @param string $content The content of the post.
	 * @return string Modified content with LaTeX protected.
	 */
	public static function wp_mathjax_latex_protect_content( $content ) {

		// echo "Here 1";

		// Protect inline and display math delimiters and block equations
		$content = preg_replace_callback('/(\$\$.*?\$\$|\$.*?\$|\\\[.*?\\\]|\\\(.*?\\\)|\\begin\{.*?\}.*?\\end\{.*?\})/s', function($matches) {
			var_dump($matches);
			return '<!-- LATEX_START -->' . htmlspecialchars($matches[0], ENT_NOQUOTES) . '<!-- LATEX_END -->';
		}, $content);

		echo $content;
		

		return $content;
	}

	/**
	 * Restore protected LaTeX content by decoding HTML entities
	 *
	 * @param string $content The content of the post.
	 * @return string Modified content with LaTeX restored.
	 */
	public static function wp_mathjax_latex_restore_content( $content ) {

		echo "Here 2";
		// Restore LaTeX content
		$content = preg_replace_callback('/<!-- LATEX_START -->(.*?)<!-- LATEX_END -->/s', function($matches) {
			return htmlspecialchars_decode($matches[1], ENT_NOQUOTES);
		}, $content);

		return $content;
	}

	public static function wp_remove_auto_br_p($content) {
		return str_replace( [ '<br/>', '<br />', '<br>', '<p>', '</p>' ], '', $content );
	}
	
	public static function wp_filter_math_content($content) {
		// echo "\n1)->".$content;
		// echo "\n2)->".html_entity_decode($content);
		// echo "\n3)->".shortcode_unautop(html_entity_decode($content));
		// echo "\n4)->".self::wp_remove_auto_br_p(shortcode_unautop(html_entity_decode($content)));
		return self::wp_remove_auto_br_p(shortcode_unautop(html_entity_decode($content)));
	}

	public static function wp_protect_math_content_new($content) {
		$is_block_math = false;
	
		// Match block LaTeX
		$regexTeXMathBlockAll = '%
		(?<!\\\\)(?:
			(\\$\\$)
			|
			(\\\\\\[)
			|
			(\\\\begin\\{(?:equation|align|gather|multline|eqnarray)\\*?\\})
		)
		(?(1)
			([\\S\\s]+?)
			(?<!\\\\)\\$\\$
		|
			([\\S\\s]+?)
			(?:
				(?(2)\\\\\\]|
				\\\\end\\{(?:equation|align|gather|multline|eqnarray)\\*?\\}
				)
			)
		)
		%ix';
	
		$content = preg_replace_callback($regexTeXMathBlockAll, function ($matches) use (&$is_block_math) {
			$is_block_math = true;
			$filtered_content = self::wp_filter_math_content($matches[0]);
			return '<!-- LATEX_START --><pre class="latex-block">' . $filtered_content . '</pre><!-- LATEX_END -->';
		}, $content);
	
		// Match inline LaTeX
		if (!$is_block_math) {
			$regexTeXInline = '%
			(?<!\\\\)(?:
				\\$
					((?:
						[^$\\\\]
						|
						\\\\[\\S\\s]
					)+?)
				(?<!\\\\)\\$
				|
				\\\\\\(
					([\\S\\s]+?)
				\\\\\\)
			)
			%ix';
	
			$content = preg_replace_callback($regexTeXInline, function ($matches) {
				$filtered_content = self::wp_filter_math_content($matches[0]);
				return '<!-- LATEX_START --><pre class="latex-inline">' . $filtered_content . '</pre><!-- LATEX_END -->';
			}, $content);
		}
	
		return $content;
	}
	/**
	 * Protects inline and block math content from being altered by WordPress formatting.
	 *
	 * This function uses regular expressions to find and wrap LaTeX math content in HTML tags
	 * that prevent WordPress from automatically adding <br> or <p> tags.
	 *
	 * @param string $content The post content to be filtered.
	 * @return string The filtered content with math protected.
	 */
	public static function wp_protect_math_content($content) {
		$is_block_math = false;

		// https://regex101.com/r/wP2aV6/25
		// 匹配行内和块状LaTeX
		$regexTeXInlineAndBlock = '
		%
		/(?<!\\)    # negative look-behind to make sure start is not escaped 
		(?:        # start non-capture group for all possible match starts
		# group 1, match dollar signs only 
		# single or double dollar sign enforced by look-arounds
		((?<!\$)\${1,2}(?!\$))|
		# group 2, match escaped parenthesis
		(\\\()|
		# group 3, match escaped bracket
		(\\\[)|                 
		# group 4, match begin equation
		(\\begin\{equation\})
		)
		# if group 1 was start
		(?(1)
		# non greedy match everything in between
		# group 1 matches do not support recursion
		(.*?)(?<!\\)
		# match ending double or single dollar signs
		(?<!\$)\1(?!\$)|  
		# else
		(?:
		# greedily and recursively match everything in between
		# groups 2, 3 and 4 support recursion
		(.*(?R)?.*)(?<!\\)
		(?:
			# if group 2 was start, escaped parenthesis is end
			(?(2)\\\)|  
			# if group 3 was start, escaped bracket is end
			(?(3)\\\]|     
			# else group 4 was start, match end equation
			\\end\{equation\}
		)
		))))%gmx';

		$regexTeXMathBlockAll = '
		%
		(?<!\\\\)    # negative look-behind to make sure start is not escaped 
		(?:          # start non-capture group for all possible match starts
			# group 1, match double dollar signs
			(\$\$)
			|
			# group 2, match escaped bracket
			(\\\[)
			|                 
			# group 3, match begin equation
			(\\begin\{(?:equation|align|gather|multline)\})
		)
		# if group 1 was start ($$)
		(?(1)
			# non greedy match everything in between
			([\S\s]+?)
			# match ending double dollar signs
			(?<!\\)\$\$
		|   # else (groups 2 or 3)
			# greedily match everything in between
			([\S\s]+?)
			(?:
				# if group 2 was start, escaped bracket is end
				(?(2)\\\]|     
				# else group 3 was start, match end equation
				\\end\{(?:equation|align|gather|multline)\}
				)
			)
		)
		%ix';

		// Protect markdown block math
		// 匹配多行LaTeX
        // 尽管只是多了一个$符号，却会引起指数级的回溯
        $regexTeXMultiline = '
        %
        \$\$
            ((?:
                [^$]+ # Not a dollar
                |
                (?<=(?<!\\\\)\\\\)\$ # Dollar preceded by exactly one slash
                )+)
            (?<!\\\\)
        \$\$ # Dollar preceded by zero slashes
        %ix';

        // 简易版本，可能存在误判，但尽可能简单，以避免上面这个LaTeX引起的性能问题
        $regexTeXMultilineLite = '
        %
		\$\$
			([\S\s]+?)
		\$\$
        %ix';

		// 匹配单行LaTeX
        $regexTeXInline = '
        %
        \$
            ((?:
                [^$]+ # Not a dollar
                |
                (?<=(?<!\\\\)\\\\)\$ # Dollar preceded by exactly one slash
                )+)
            (?<!\\\\)
        \$ # Dollar preceded by zero slashes
        %ix';

        // 简易版本，可能存在误判，但尽可能简单，以避免上面这个LaTeX引起的性能问题
        $regexTeXMultilineLite = "/\$[\S\ ]+?\$/ix";

		// 匹配块级LaTeX，主要针对块级数学公式，例如 \begin{equation} ... \end{equation}
		$regexTeXMathBlock = '/\\begin\{(.+)\}([\s\S]*?)\\end\{\1\}/s';; 

		$is_block_math = false;

		$res_content = $content;

		// echo "\n\n<br />1 content = **->".$content.'<-**';

		$content = preg_replace_callback($regexTeXMathBlockAll, function ($matches) {
			if ( count( $matches ) === 1 ) {
				// No matches found.
				return $matches[0]; // 返回完整匹配.
			}

			$is_block_math = true;

			echo "\n\n<br />block math = ".self::wp_filter_math_content( $matches[0] );
			$res_content = '<!-- LATEX_START --><pre class="latex-block">' . self::wp_filter_math_content( $matches[0] ) . '</pre><!-- LATEX_END -->';

			return $res_content;
		}, $content);


		$content = preg_replace_callback($regexTeXMultiline, function ($matches) {
			if ( count( $matches ) === 1 ) {
				// No matches found.
				return $matches[0]; // 返回完整匹配.
			}

			$is_block_math = true;

			echo "\n\n<br />display math = ".self::wp_filter_math_content( $matches[0] );
			$res_content = '<!-- LATEX_START --><pre class="latex-block">' . self::wp_filter_math_content( $matches[0] ) . '</pre><!-- LATEX_END -->';

			return $res_content;
		}, $content);

		if ($is_block_math === false) {
			echo "\n\n<br />22 content = **->".$content.'<-**';
			$content = preg_replace_callback($regexTeXMathBlock, function ($matches) {
				echo "hahaha----";
				var_dump($matches);
				if ( count( $matches ) === 1 ) {
					// No matches found.
					return $matches[0]; // 返回完整匹配.
				}
	
				$is_block_math = true;
	
				echo "\n\n<br />display math block = ".self::wp_filter_math_content( $matches[0] );
				$res_content = '<!-- LATEX_START --><pre class="latex-block">' . self::wp_filter_math_content( $matches[0] ) . '</pre><!-- LATEX_END -->';

				return $res_content;
			}, $content);

			echo "\n\n<br />2 content = **->".$content.'<-**';
		}

		// echo "content = ".$content;

		// Try inline math matching when not block math
		// e.g. block math $$E=m^c^2$$ no need to match inline math.
		if ($is_block_math === false) {
			// Protect markdown inline math
			$content = preg_replace_callback($regexTeXInline, function ($matches) {
				if ( count( $matches ) === 1 ) {
					// No matches found.
					return $matches [0]; // 返回完整匹配.
				}

				// if ( $matches[0] )
				echo "\n\n<br />inline math = ".self::wp_filter_math_content( $matches[0] );
				$res_content = '<!-- LATEX_START --><pre class="latex-inline">' . self::wp_filter_math_content( $matches[0] ) . '</pre><!-- LATEX_END -->';

				return $res_content;
			}, $content);
		}

		// var_dump($content);

		return $res_content;
	}

	/**
	 * Enqueue/add the JavaScript to the <head> tag.
	 */
	public static function add_script() {
		if ( ! self::$add_script ) {
			return;
		}

		if ( self::$block_script ) {
			return;
		}

		// Initialise option for existing MathJax-LaTeX users.
		if ( get_option( 'kblog_mathjax_use_cdn' ) || ! get_option( 'kblog_mathjax_custom_location' ) ) {
			// $mathjax_location = 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/' . MATHJAX_JS_VERSION . '/MathJax.js';
			$mathjax_location = 'https://cdn.jsdelivr.net/npm/mathjax@' . MATHJAX_JS_VERSION . '/es5/tex-chtml.js';
			
		} else {
			$mathjax_location = get_option( 'kblog_mathjax_custom_location' );
		}

		$config = get_option( 'kblog_mathjax_config' );
		if ( ! $config ) {
			$config = 'default';
		}
		$mathjax_url = add_query_arg( 'config', $config, $mathjax_location );

		// wp_enqueue_script( 'mathjax', $mathjax_url, false, MATHJAX_PLUGIN_VERSION, false );

		wp_enqueue_script(
			'mathjax',
			$mathjax_url,
			array(),
			MATHJAX_PLUGIN_VERSION,
			array( 
				'in_footer' => true,
				// 'strategy'  => 'defer',
			)
			);
		
		add_filter( 'script_loader_tag', array( __CLASS__, 'add_async_to_mathjax_script'), 10, 3 );

		// wp_script_add_data( 'mathjax', 'async/defer' , true );

		// wp_register_script( 
		// 	'mathjax', 
		// 	$mathjax_url, 
		// 	array(), 
		// 	MATHJAX_PLUGIN_VERSION, 
		// 	array(
		// 		'in_footer' => true,
		// 		'strategy'  => 'async',
		// 	)
		// )

		$mathjax_config = apply_filters( 'mathjax_config', [] );
		if ( $mathjax_config ) {
			wp_add_inline_script( 'mathjax', 'MathJax.Hub.Config(' . wp_json_encode( $mathjax_config ) . ');' );
		}

		wp_add_inline_script( 'mathjax', 'MathJax = {
			tex: {
			  tags: \'all\'
			}
		  };' );

		// wp_add_inline_script( 'mathjax', "MathJax = {\n  tex: {\n    inlineMath: [['$','$'],['\\\\(','\\\\)']], \n    processEscapes: true\n  },\n  options: {\n    ignoreHtmlClass: 'tex2jax_ignore|editor-rich-text'\n  }\n};\n" );
		// add_filter( 'mathjax', array( __CLASS__, 'add_mathjax_script_async' ), 10, 2 );
		// echo "Here!";

	}


	/**
	 * Set the script tag to have type text/x-mathjax-config
	 *
	 * @param string $tag    The `<script>` tag for the enqueued script.
	 * @param string $handle The script's registered handle.
	 * @param string $src    The script's source URL.
	 *
	 * @return string $tag
	 */
	public static function script_loader_tag( $tag, $handle = null, $src = null ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		if ( 'mathjax' === $handle ) {
			// Replace the <script> tag for the inline script, but not for the <script> tag with src="".
			return str_replace( "<script type='text/javascript'>", "<script type='text/x-mathjax-config'>", $tag );
		}

		return $tag;
	}

	/**
	 * Content filter that replaces inline $latex with [latex] shortcode.
	 *
	 * @param string $content    The page content.
	 */
	public static function inline_to_shortcode( $content ) {
		if ( false === strpos( $content, '$latex' ) ) {
			return $content;
		}

		self::$add_script = true;

		return preg_replace_callback( '#\$latex[= ](.*?[^\\\\])\$#', [ __CLASS__, 'inline_to_shortcode_callback' ], $content );
	}

	/**
	 * Callback for inline_to_shortcode() regex.
	 *
	 * Also support wp-latex syntax. This includes the ability to set background and foreground
	 * colour, which we can ignore.
	 *
	 * @param array $matches    Regular expression matches.
	 */
	public static function inline_to_shortcode_callback( $matches ) {
		if ( preg_match( '/.+((?:&#038;|&amp;)s=(-?[0-4])).*/i', $matches[1], $s_matches ) ) {
			$matches[1] = str_replace( $s_matches[1], '', $matches[1] );
		}

		if ( preg_match( '/.+((?:&#038;|&amp;)fg=([0-9a-f]{6})).*/i', $matches[1], $fg_matches ) ) {
			$matches[1] = str_replace( $fg_matches[1], '', $matches[1] );
		}

		if ( preg_match( '/.+((?:&#038;|&amp;)bg=([0-9a-f]{6})).*/i', $matches[1], $bg_matches ) ) {
			$matches[1] = str_replace( $bg_matches[1], '', $matches[1] );
		}

		return "[latex]{$matches[1]}[/latex]";
	}

	/**
	 * Add a link to settings on the plugin management page.
	 *
	 * @param string[] $actions     An array of plugin action links. By default this can include 'activate',
	 *                              'deactivate', and 'delete'. With Multisite active this can also include
	 *                              'network_active' and 'network_only' items.
	 * @param string   $plugin_file Path to the plugin file relative to the plugins directory.
	 */
	public static function mathjax_settings_link( $actions, $plugin_file ) {
		if ( 'mathjax-latex/mathjax-latex.php' === $plugin_file && function_exists( 'admin_url' ) ) {
			$settings_link = '<a href="' . esc_url( admin_url( 'options-general.php?page=kblog-mathjax-latex' ) ) . '">' . esc_html__( 'Settings' ) . '</a>';
			array_unshift( $actions, $settings_link );
		}
		return $actions;
	}

	/**
	 * Removes the <br /> tags inside math tags.
	 *
	 * @param string $content  The page content.
	 *
	 * @return string without <br /> tags
	 */
	public static function filter_br_tags_on_math( $content ) {
		$filtered_content = preg_replace_callback(
			'/(<math.*>.*<\/math>)/isU',
			function ( $matches ) {
				return str_replace( [ '<br/>', '<br />', '<br>' ], '', $matches[0] );
			},
			$content
		);
		return null === $filtered_content ? $content : $filtered_content;
	}

	/**
	 * Allow MathML tags within WordPress
	 * http://vip.wordpress.com/documentation/register-additional-html-attributes-for-tinymce-and-wp-kses/
	 * https://developer.mozilla.org/en-US/docs/Web/MathML/Element
	 */
	public static function allow_mathml_tags() {
		global $allowedposttags;

		foreach ( self::$mathml_tags as $tag => $attributes ) {
			$allowedposttags[ $tag ] = []; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

			foreach ( $attributes as $a ) {
				$allowedposttags[ $tag ][ $a ] = true; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			}
		}
	}

	/**
	 * Ensure that the MathML tags will not be removed
	 * by the TinyMCE editor
	 *
	 * @param array $options  Array of TinyMCE options.
	 *
	 * @return array of TinyMCE options.
	 */
	public static function allow_mathml_tags_in_tinymce( $options ) {

		$extended_tags = [];

		foreach ( self::$mathml_tags as $tag => $attributes ) {
			if ( ! empty( $attributes ) ) {
				$tag = $tag . '[' . implode( '|', $attributes ) . ']';
			}

			$extended_tags[] = $tag;
		}

		if ( ! isset( $options['extended_valid_elements'] ) ) {
			$options['extended_valid_elements'] = '';
		}

		$options['extended_valid_elements'] .= ',' . implode( ',', $extended_tags );
		$options['extended_valid_elements']  = trim( $options['extended_valid_elements'], ',' );

		return $options;
	}
}

MathJax_Latex::init();
