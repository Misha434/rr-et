resource "aws_route_table" "rret-rt" {
  vpc_id = aws_vpc.rret-vpc.id
  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = aws_internet_gateway.rret-igw.id
  }
}

resource "aws_route_table_association" "public-1a" {
  subnet_id      = aws_subnet.public-subnet-1a.id
  route_table_id = aws_route_table.rret-rt.id
}

resource "aws_route_table_association" "public-1c" {
  subnet_id      = aws_subnet.public-subnet-1c.id
  route_table_id = aws_route_table.rret-rt.id
}