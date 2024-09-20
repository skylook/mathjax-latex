<?php

// The improved regex pattern
$pattern = '/
    (?<!\\\\)                     # Negative lookbehind to avoid escaped delimiters
    (?:
        # LaTeX environments (including equation, align, gather, multline, array, and others)
        \\\\begin\{([^}]+)\}      # Capture the environment name
        (?:
            (?!\\\\end\{\1\}).    # Match any character that\'s not the closing of this specific environment
        )*?
        \\\\end\{\1\}             # Match the corresponding \end{...}
    |
        # Block math with $$
        \$\$(?=[^$])              
        (?:                       
            [^$]++                
            (?:                   
                \$(?!\$)          
                [^$]++            
            )*+                   
        )
        \$\$                      
    |
        # Inline math with single $
        \$(?=\S)(?!\$)            
        (?:                       
            [^$]++                
            (?:                   
                \$(?!\$)          
                [^$]++            
            )*+                   
        )
        \$                        
    |
        # Block math with \[...\]
        \\\[                      
        (?:                       
            [^]]*+                
            (?:                   
                ](?!\])           
                [^]]*+            
            )*+                   
        )
        \\\]                      
    |
        # Inline math with \(...\)
        \\\(                      
        (?:                       
            [^)]*+                
            (?:                   
                \)(?!\))          
                [^)]*+            
            )*+                   
        )
        \\\)                      
    )
/sx';

// Sample LaTeX text with various math environments
$text = <<<EOT
Here's some sample text with various LaTeX math environments:

1. Inline math: $E = mc^2$

2. Block math with double dollars:
$$
\int_0^\infty e^{-x^2} dx = \frac{\sqrt{\pi}}{2}
$$

3. Equation environment:
\begin{equation}
  \int_0^\infty \frac{x^3}{e^x-1}\,dx = \frac{\pi^4}{15}
  \label{eq:sample3}
\end{equation}

4. Align environment:
\begin{align}
  2x - 5y &=  8 \\
  3x + 9y &=  -12
\end{align}

5. Array environment:
\begin{array}{ccccccccccccccccccccc}
\RL{'isqA.t} &&&&&&&& 2.1 &&&&& Projection\\
\RL{'in`kAs} &&&&&&&& 2.1 &&&&& R\acute{e}flexion\\
\RL{'iltwA' } &&&&&&&&  2.1 &&&&& Torsion
\end{array}

6. Inline math with \(...\): The quadratic formula is \(x = \frac{-b \pm \sqrt{b^2 - 4ac}}{2a}\)

7. Block math with \[...\]:
\[
  \sum_{n=1}^{\infty} \frac{1}{n^2} = \frac{\pi^2}{6}
\]

This is not math: $5.99 and $10.99 are prices.

EOT;

// Function to test the regex pattern
function testRegexPattern($pattern, $text) {
    preg_match_all($pattern, $text, $matches);
    
    echo "Found " . count($matches[0]) . " matches:\n\n";
    
    foreach ($matches[0] as $index => $match) {
        echo "Match " . ($index + 1) . ":\n";
        echo htmlspecialchars($match) . "\n\n";
    }
}

// Run the test
testRegexPattern($pattern, $text);

// Use the regex pattern to extract math expressions from the text
// preg_match_all($pattern, $text, $matches);

?>
