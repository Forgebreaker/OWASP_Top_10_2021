# Bounty Boys: Server-Side Request Forgery

SSRF is a type of cybersecurity vulnerability where an attacker can manipulate a server to make requests on their behalf. Imagine the server is like a helpful but gullible friend who trusts you blindly and will do favors for you without questioning them.

In an SSRF scenario, there's a server that can make requests to other systems. This is common, as servers often need to communicate with other services, like databases, APIs, or internal resources.

An attacker finds a way to trick this server into making a request that it shouldn't. For example, let's say there's a website where you can download images from the internet by providing a URL. The server takes this URL and fetches the image for you.

What can go wrong:

  + Without proper access controls, a compromised server might access sensitive areas of the network or perform unauthorized actions, leading to data breaches or system disruptions.

  + If the server doesn't adequately validate or sanitize user inputs, attackers can craft malicious inputs (like URLs) that trick the server into accessing unauthorized resources.
