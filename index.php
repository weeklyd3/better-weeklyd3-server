<html>
  <head>
    <title>API Documentation</title>
      <link rel="stylesheet"
      href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/styles/vs.min.css" />
      <link rel="stylesheet" href="https://harmlesswebsite.leoshi6.repl.co/style.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/highlight.min.js"></script>
<script>window.addEventListener('DOMContentLoaded', function() { hljs.highlightAll(); });</script>
  </head>
  <body id="baudy">
    <h1>API Manual</h1>
      <p>This provides information for the requests made to the API.</p>
      <p>The manual is auto-generated based on some data. <a href="manual.json">Find the data here</a>.</p>
      <?php 
require 'prettify.php';
// Load manual
$methods = json_decode(file_get_contents('manual.json'), true);
foreach ($methods as $desc => $method) {
    ?><h2><?php echo htmlspecialchars($desc); ?></h2>
    <h3>Description</h3>
    <p><?php echo htmlspecialchars($method['description']); ?></p>
    <h3>Query URL</h3>
      <p>Query the following URL: <code class="querythis">/<?php echo $method['url']; ?></code></p>
    <h3>Request Details</h3>
      <p>The request must be made in one of the following methods:</p>
      <ul class="request-methods">
          <?php foreach ($method['method'] as $m) {
            ?><li><?php echo htmlspecialchars($m); ?></li><?php
          } ?>
      </ul>
    <p>The following parameters should be specified:</p>
    <?php if (!count($method['params'])) { ?><p>No parameters are needed.</p><?php } else { ?>
    <ul>
    <?php 
    foreach ($method['params'] as $name => $param) { ?><li>
         <code><?php echo htmlspecialchars($name); ?></code>: <?php echo htmlspecialchars($param); ?></li><?php } ?>
    </ul>
   <?php } ?>
    <h3>Possible Output</h3>
      <p>The following table outlines the possible situations and the response in each of them:</p>
      <table>
          <caption>Possible Responses</caption>
          <tr>
              <th>Scenario</th>
              <th>Description</th>
              <th>Successful?</th>
              <th>Example Output</th>
          </tr>
          <?php 
    foreach ($method['situations'] as $name => $output) {
        ?><tr>
            <td><?php echo $name; ?></td>
            <td><?php echo $output['description']; ?></td>
            <td><?php echo $output['success'] ? 'Yes' : "No"; ?></td>
        <td><pre><code><?php echo $output['output']; ?></code></pre></td>
        </tr><?php
    }
    ?>
      </table>
    <?php
}
?>
<h2>License</h2>
      <p>You can use either of two licenses:</p>
      <ul>
          <li>
      <span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">The Weekly D3 News Server Manual</span> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribution-ShareAlike 4.0 International License</a>. <em>This license is recommended when copying or making changes!</em></li>
          <li>It is also licensed under the GNU Free Documentation License, either version 1.3 as published by the Free Software Foundation, or (at your option) any later version. It has no invariant sections, no front cover texts, and no back cover texts. A copy of the GNU Free Documentation License can be found at <a href="fdl.txt">/fdl.txt</a>.</li>
      </ul>
  </body>
</html>