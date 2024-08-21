<?php
$re = '/\$(.*?)\$|\\\\\((.*?)\\\\\)/s';
$str = 'In equation $\\eqref{eq:sample}$ and \\(\\eqref{eq:sample}\\), we find the value of an interesting integral:

$$\\begin{equation}
  \\int_0^\\infty \\frac{x^3}{e^x-1}\\,dx = \\frac{\\pi^4}{15}
  \\label{eq:sample}
\\end{equation}$$

\\[\\begin{equation}
  \\int_0^\\infty \\frac{x^3}{e^x-1}\\,dx = \\frac{\\pi^4}{15}
  \\label{eq:sample}
\\end{equation}\\]

$$E=mc^2$$';
// $subst = '';

$result = wp_protect_math_content($str);

echo "替换的结果是 ".$result;


function wp_protect_math_content($content) {
    // Protect markdown block math
    $content = preg_replace_callback('/\$\$(.*?)\$\$|\\\[(.*?)\\\]/', function ($matches) {
        if ( count( $matches ) === 1 ) {
            // No matches found.
            return $matches [0]; // 返回完整匹配.
        }
        return '<!-- LATEX_START --><div class="latex-block">' . esc_html($matches[0]) . '</div><!-- LATEX_END -->';
    }, $content);

    // Protect markdown inline math
    $content = preg_replace_callback('/\$(.*?)\$|\\\((.*?)\\\)/', function ($matches) {
        if ( count( $matches ) === 1 ) {
            // No matches found.
            return $matches [0]; // 返回完整匹配.
        }
        return '<!-- LATEX_START --><span class="latex-inline">' . esc_html($matches[0]) . '</span><!-- LATEX_END -->';
    }, $content);

    var_dump($content);

    return $content;
}
?>