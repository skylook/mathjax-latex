$re = '%
		(?<!\\\\\\\\)    # negative look-behind to make sure start is not escaped 
		(?:          # start non-capture group for all possible match starts
			# group 1, match double dollar signs
			(\$\$)
			|
			# group 2, match escaped bracket
			(\\\\\[)
			|                 
			# group 3, match begin equation
			(\\\\begin\{(?:equation|align|gather|multline)\})
		)
		# if group 1 was start ($$)
		(?(1)
			# non greedy match everything in between
			([\S\s]+?)
			# match ending double dollar signs
			(?<!\\\\)\$\$
		|   # else (groups 2 or 3)
			# greedily match everything in between
			([\S\s]+?)
			(?:
				# if group 2 was start, escaped bracket is end
				(?(2)\\\\\]|     
				# else group 3 was start, match end equation
				\\\\end\{(?:equation|align|gather|multline)\}
				)
			)
		)
		%ix';
$str = '<p>Test equation</p>



<p>[latex display]E=mc^2[/latex]</p>



<p>[latex display]\\begin{equation}<br>  \\int_0^\\infty \\frac{x^3}{e^x-1}\\,dx = \\frac{\\pi^4}{15}<br>  \\label{eq:sample1}<br>\\end{equation}[/latex]</p>

\\begin{equation}<br>  \\int_0^\\infty \\frac{x^3}{e^x-1}\\,dx = \\frac{\\pi^4}{15}<br>  \\label{eq:sample1}<br>\\end{equation}

<p></p>

\\begin{equation} match \\end{equation}

\\begin{equation}
match
\\end{equation}

<pre class="wp-block-preformatted">In equation $\\eqref{eq:sample1}$ and \\(\\eqref{eq:sample2}\\), we find the value of an interesting integral:<br><br><br><br>\\[\\begin{equation}<br>  \\int_0^\\infty \\frac{x^3}{e^x-1}\\,dx = \\frac{\\pi^4}{15}<br>  \\label{eq:sample3}<br>\\end{equation}\\]<br><br>\\begin{equation}<br>  \\int_0^\\infty \\frac{x^3}{e^x-1}\\,dx = \\frac{\\pi^4}{15}<br>  \\label{eq:sample4}<br>\\end{equation}<br><br> </pre>
';
$subst = '';

$result = preg_replace($re, $subst, $str);

echo "替换的结果是 ".$result;
