<p>This page currently just allows users to check what cards I have/want in my
Magic the Gathering collection, but I have thoughts of many things I may add one
day:
	<ul>
		<li>Allow users to store their own card databases here as well</li>
		<li>Adding pricing information</li>
		<li>Building in a trading application so people could build up/propose a trade with me</li>
		<li>Build a deckbuilding/testing application, though this is a pretty long shot of a goal
			unless I lose my job or someone offers to pay me to create such a thing...or you know...
			all my friends move away and my wife dies in a terrible Netflix accident.  One way or
			another, I would need some real time for this.
		</li>
	</ul>
</p>
<p>The main thing I wanted to do with this homepage for now was just give a shoutout to a couple
	opensource projects I've been pulling from for this page:
	<ul>
		<li>First off, <a href"api.mtgdb.info">api.mtgdb.info</a> is a web service that returns
		JSON data of Magic cards/sets/etc.  I had been trying to figure out the best way to keep
		my own database up to date with all the card/set information, and this service became
		available right before I really started working on the site.  It made it much easier
		than the other options I had been thinking about.  Using their api, I was able to set
		things up such that I can automatically check for new sets and update my card database.
		</li>
		<li>Also, I made use of <a href="http://usercake.com/">Usercake</a> for my user/page
		privilege management system.  It's been super easy to work with, and I'm very greatful
		I didn't have to develop my own privilege management system.
		</li>
		<li>For the menubar, I used Dynamic Drive's
		<a href="http://www.dynamicdrive.com/dynamicindex1/ddsmoothmenu.htm">DDSmoothMenu</a>.
		<li>This one's not exactly unique or unknown (more like expected), but let's give it up for
		<a href="jquery.com">jQuery</a> for being awesome!
		</li>
		<li>I apologize if I missed anyone.  It doesn't mean you're not appreciated, it just means
		I'm very forgetful.
		</li>
		<li>Also, as an aside, the source for my page is available
		<a href="https://github.com/addugger/magicdugger">here</a>.  Most of it is generally useless
		to most people, but the section where I update the database could potentially be useful for
		someone looking to keep a similar database of all the cards.
		</li>
	</ul>
</p>
