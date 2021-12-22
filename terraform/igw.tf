resource "aws_internet_gateway" "rret-igw" {
  vpc_id = aws_vpc.rret-vpc.id

  tags = {
    Name = "rret-igw"
  }
}