# wgz
Compression - Wonderful Gnu Zip (Zap: Zip Application)

# WGZ File Format

A 0 in a line of 1's is the value of the nth bits used, describing the real value of the binary number to be recognized

A 1 is a spacer between the 0's

The program works best using 4 bits to be used at once. This is called the `$insert` constant

WGZ loads 128 bytes at a time (as of this README modification [4/7/2022])

It counts out the 0-15 0s and 1s needed to recognize the value. Considering, this may seem unintelligible, literally, moronic.

But fortunately, This is not the case. The bit bucket actually wraps in 1-15 bits. This is stellar.

Because of this limit, it can be run on any file exemplfying upto 4% compressed value.

As is the perfect notion for it. Therefore, it is made with care and acknowledgement, hence the reason I put it up here.

I've been working thru this for 8 years. Probably to the date. Because I and my girlfriend's anniversary is coming up (14 years of happiness, practically bliss).

So, if you're eager to do some programming, and want to give me a wedding gift, this would be it. Thank you. I thank anyone who wants to
try and put the decompression right. Or, if you leave an issue, please tell me where I've been wrong in the code. Thank you, too. Okay!

From me and my Wedful Wife, WGZ is born. The best zipping method there will ever be..(?)

Goodnight!
